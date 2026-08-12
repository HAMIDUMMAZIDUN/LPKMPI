<?php

namespace App\Http\Controllers;

use App\Models\TraineeEnrollment;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    /**
     * Send OTP verification code to trainee email.
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
            'email.email' => 'Format email tidak valid.',
            'email.required' => 'Email wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        session()->put("otp_{$email}", [
            'code' => $otp,
            'expires_at' => $expiresAt,
        ]);

        try {
            Mail::raw("Kode verifikasi pendaftaran Anda di LPK MPI adalah: {$otp}. Kode ini berlaku selama 10 menit.", function ($message) use ($email) {
                $message->to($email)
                        ->subject("Kode Verifikasi Pendaftaran LPK MPI");
            });
        } catch (\Exception $e) {
            logger()->error("Failed to send OTP email: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode verifikasi telah dikirim ke email Anda.',
            'debug_code' => (config('mail.default') === 'log' || app()->environment('local', 'testing')) ? $otp : null,
        ]);
    }

    /**
     * Handle trainee enrollment.
     */
    public function enroll(Request $request)
    {
        $rules = [
            'program_id' => 'required|exists:training_programs,id',
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'phone' => 'required|string|max:50',
            'education' => 'required|string',
            'category' => 'required|string',
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'otp_code' => 'required',
            'ktp' => 'required|file|image|max:2048',
            'ijazah' => 'required|file|image|max:2048',
        ];

        $messages = [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
            'otp_code.required' => 'Kode verifikasi email wajib diisi.',
            'ktp.required' => 'File KTP wajib diunggah.',
            'ktp.image' => 'File KTP harus berupa gambar (jpg, jpeg, png).',
            'ktp.max' => 'Ukuran file KTP maksimal 2MB.',
            'ijazah.required' => 'File Ijazah wajib diunggah.',
            'ijazah.image' => 'File Ijazah harus berupa gambar (jpg, jpeg, png).',
            'ijazah.max' => 'Ukuran file Ijazah maksimal 2MB.',
        ];

        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->after(function ($validator) use ($request) {
                $email = $request->email;
                if (!$email) return;
                $sessionOtp = session()->get("otp_{$email}");
                if (!$sessionOtp || $sessionOtp['code'] != $request->otp_code || now()->greaterThan($sessionOtp['expires_at'])) {
                    $validator->errors()->add('otp_code', 'Kode verifikasi salah atau telah kedaluwarsa.');
                }
            });

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
        } else {
            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->after(function ($validator) use ($request) {
                $email = $request->email;
                if (!$email) return;
                $sessionOtp = session()->get("otp_{$email}");
                if (!$sessionOtp || $sessionOtp['code'] != $request->otp_code || now()->greaterThan($sessionOtp['expires_at'])) {
                    $validator->errors()->add('otp_code', 'Kode verifikasi salah atau telah kedaluwarsa.');
                }
            });
            $validator->validate();
        }

        // Clear OTP from session upon successful validation
        session()->forget("otp_{$request->email}");

        // Store file uploads
        $ktpPath = null;
        if ($request->hasFile('ktp')) {
            $ktpPath = $request->file('ktp')->store('enrollments/ktp', 'public');
        }

        $ijazahPath = null;
        if ($request->hasFile('ijazah')) {
            $ijazahPath = $request->file('ijazah')->store('enrollments/ijazah', 'public');
        }

        $program = TrainingProgram::findOrFail($request->program_id);
        // Clean price string to integer amount (e.g. "Rp 1.500.000" -> 1500000)
        $cleanPrice = (int) str_replace(['Rp', '.', ' ', ','], '', $program->price);

        // Create enrollment
        $enrollment = TraineeEnrollment::create([
            'training_program_id' => $request->program_id,
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'phone' => $request->phone,
            'education' => $request->education,
            'category' => $request->category,
            'company' => $request->company,
            'position' => $request->position,
            'ktp_path' => $ktpPath,
            'ijazah_path' => $ijazahPath,
            'payment_method' => null,
            'payment_status' => 'UNPAID',
            'payment_reference' => null,
            'payment_amount' => $cleanPrice,
            'certificate_number' => null,
            'certificate_date' => null,
            'status' => 'PROSES',
        ]);

        // Create user account if it doesn't exist
        $user = \App\Models\User::where('email', $request->email)->first();
        $plainPassword = null;
        if (!$user) {
            $plainPassword = 'mpi-' . rand(100000, 999999);
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($plainPassword),
                'password_plain' => $plainPassword,
                'role' => 'asesi',
            ]);
        }

        // Send email with credentials/authentication details
        try {
            $loginUrl = route('login');
            $passwordText = $plainPassword ?? $user->password_plain ?? '(Gunakan password Anda yang sudah terdaftar)';
            
            $emailContent = "Selamat! Pendaftaran Anda di LPK MPI telah berhasil.\n\n"
                . "Detail Pendaftaran:\n"
                . "- Nama: {$enrollment->name}\n"
                . "- Program Pelatihan: {$program->title}\n"
                . "- Biaya Pelatihan: Rp " . number_format($enrollment->payment_amount, 0, ',', '.') . "\n\n"
                . "Sistem telah membuat/menghubungkan akun Asesi Anda agar dapat masuk ke Dashboard Ujian & LMS:\n"
                . "- URL Login: {$loginUrl}\n"
                . "- Username: {$user->username}\n"
                . "- Email: {$user->email}\n"
                . "- Password: {$passwordText}\n\n"
                . "Silakan gunakan kredensial di atas untuk masuk ke akun Anda. Simpan informasi ini secara aman.\n\n"
                . "Hormat kami,\n"
                . "Administrasi LPK MPI";

            Mail::raw($emailContent, function ($message) use ($enrollment) {
                $message->to($enrollment->email)
                        ->subject("Detail Akun & Pendaftaran LPK MPI - {$enrollment->name}");
            });
        } catch (\Exception $e) {
            logger()->error("Failed to send enrollment authentication email: " . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran awal berhasil, silakan lakukan pembayaran.',
                'enrollment' => [
                    'id' => $enrollment->id,
                    'name' => $enrollment->name,
                    'email' => $enrollment->email,
                    'phone' => $enrollment->phone,
                    'payment_amount' => $enrollment->payment_amount,
                    'payment_amount_formatted' => 'Rp ' . number_format($enrollment->payment_amount, 0, ',', '.'),
                    'program_title' => $program->title,
                ],
                'trainee' => [
                    'name' => $enrollment->name,
                    'program' => [
                        'title' => $program->title,
                    ],
                    'cert_number' => $enrollment->certificate_number ?? 'PENDING (Belum Diverifikasi)',
                    'cert_date' => $enrollment->certificate_date ? $enrollment->certificate_date->format('d M Y') : now()->format('d M Y'),
                ]
            ]);
        }

        return redirect()->back()->with([
            'success' => 'Pendaftaran sukses! Silakan hubungi admin untuk pembayaran.',
            'new_enrollment' => $enrollment,
        ]);
    }

    /**
     * Process simulated payment gateway transaction.
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:trainee_enrollments,id',
            'payment_method' => 'required|string',
        ]);

        $enrollment = TraineeEnrollment::findOrFail($request->enrollment_id);
        
        // Generate a random reference number
        $refNumber = 'MPI-PAY-' . strtoupper(Str::random(10));
        
        $enrollment->update([
            'payment_method' => $request->payment_method,
            'payment_status' => 'PAID',
            'payment_reference' => $refNumber,
        ]);

        // Simulating the auto confirmation notification
        try {
            Mail::raw("Kuitansi Pembayaran LPK MPI\n\nNo. Transaksi: {$refNumber}\nPeserta: {$enrollment->name}\nProgram: {$enrollment->trainingProgram->title}\nJumlah: Rp " . number_format($enrollment->payment_amount, 0, ',', '.') . "\nStatus: LUNAS\n\nTerima kasih telah melakukan pembayaran. Pendaftaran Anda sedang diproses oleh admin.", function ($message) use ($enrollment) {
                $message->to($enrollment->email)
                        ->subject("Kuitansi Pembayaran LPK MPI - {$enrollment->name}");
            });
        } catch (\Exception $e) {
            logger()->error("Failed to send payment confirmation email: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi!',
            'receipt' => [
                'reference' => $refNumber,
                'name' => $enrollment->name,
                'program' => $enrollment->trainingProgram->title,
                'amount' => 'Rp ' . number_format($enrollment->payment_amount, 0, ',', '.'),
                'method' => $request->payment_method,
                'date' => now()->format('d M Y H:i') . ' WIB',
            ]
        ]);
    }
}
