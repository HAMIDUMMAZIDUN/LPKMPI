<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TrainingProgram;
use App\Models\TraineeEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImportExportController extends Controller
{
    /** Check if user has admin or superadmin access. */
    private function checkAccess()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Akses Ditolak.');
        }
    }

    // ────────────────────────────────────────────────────────────────────────
    // USER ACCOUNTS IMPORT/EXPORT
    // ────────────────────────────────────────────────────────────────────────

    public function exportUsers()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['username', 'email', 'name', 'role', 'password_plain'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $users = User::all();
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->username,
                    $user->email,
                    $user->name ?? $user->username,
                    $user->role,
                    $user->password_plain ?? 'password123'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importUsers(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            // Clean up BOM and whitespace from headers
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['username', 'email', 'role'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue; // Skip malformed rows
                }
                
                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                // Ensure optional keys exist
                foreach (['name', 'password_plain'] as $key) {
                    if (!array_key_exists($key, $data)) {
                        $data[$key] = null;
                    }
                }

                // Validation
                $validator = Validator::make($data, [
                    'username' => 'required|string|max:255',
                    'email'    => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
                    'role'     => 'required|in:superadmin,admin,asesor,asesi,instruktur',
                    'password_plain' => 'nullable|string|min:8'
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $password = $data['password_plain'] ?? 'password123';

                // Check uniqueness or update existing
                $existingUser = User::where('email', $data['email'])->orWhere('username', $data['username'])->first();

                if ($existingUser) {
                    $existingUser->update([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => $data['role'],
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                } else {
                    User::create([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => $data['role'],
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                }
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount akun pengguna berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                if (count($errorRows) > 5) {
                    $msg .= "\n...dan " . (count($errorRows) - 5) . " kesalahan lainnya.";
                }
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // TRAINING PROGRAMS IMPORT/EXPORT
    // ────────────────────────────────────────────────────────────────────────

    public function exportPrograms()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="programs_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['id', 'title', 'category', 'duration', 'description', 'price', 'lsp_keyword', 'benefits'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $programs = TrainingProgram::all();
            foreach ($programs as $prog) {
                $benefitsStr = is_array($prog->benefits) ? implode('|', $prog->benefits) : '';
                fputcsv($file, [
                    $prog->id,
                    $prog->title,
                    $prog->category,
                    $prog->duration,
                    $prog->description,
                    $prog->price,
                    $prog->lsp_keyword,
                    $benefitsStr
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importPrograms(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['title', 'category', 'duration', 'price', 'lsp_keyword'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue;
                }

                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                // Ensure optional keys exist
                foreach (['id', 'description', 'benefits'] as $key) {
                    if (!array_key_exists($key, $data)) {
                        $data[$key] = null;
                    }
                }

                $validator = Validator::make($data, [
                    'title'       => 'required|string|max:255',
                    'category'    => 'required|string|max:100',
                    'duration'    => 'required|string|max:100',
                    'description' => 'nullable|string',
                    'price'       => 'required|string|max:100',
                    'lsp_keyword' => 'required|string|max:100',
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $id = !empty($data['id']) ? $data['id'] : Str::slug($data['title'], '_') . '_prog';
                $benefits = !empty($data['benefits']) ? explode('|', $data['benefits']) : [];

                TrainingProgram::updateOrCreate(
                    ['id' => $id],
                    [
                        'title' => $data['title'],
                        'category' => $data['category'],
                        'duration' => $data['duration'],
                        'description' => $data['description'] ?? '',
                        'price' => $data['price'],
                        'lsp_keyword' => $data['lsp_keyword'],
                        'benefits' => $benefits
                    ]
                );
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount program pelatihan berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // TRAINEE ENROLLMENTS IMPORT/EXPORT
    // ────────────────────────────────────────────────────────────────────────

    public function exportTrainees()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="trainees_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = [
            'name', 'nik', 'email', 'phone', 'education', 'category', 
            'company', 'position', 'training_program_id', 'payment_method', 
            'payment_status', 'payment_amount', 'status'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $trainees = TraineeEnrollment::all();
            foreach ($trainees as $t) {
                fputcsv($file, [
                    $t->name,
                    $t->nik,
                    $t->email,
                    $t->phone,
                    $t->education,
                    $t->category,
                    $t->company,
                    $t->position,
                    $t->training_program_id,
                    $t->payment_method ?? 'Bank Transfer (Virtual Account)',
                    $t->payment_status ?? 'PENDING',
                    $t->payment_amount ?? 0,
                    $t->status ?? 'PENDING'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importTrainees(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['name', 'nik', 'email', 'phone', 'education', 'category', 'training_program_id'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue;
                }

                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                // Ensure optional keys exist
                $optionalKeys = [
                    'company', 'position', 'payment_method', 'payment_status', 
                    'payment_amount', 'status', 'payment_reference'
                ];
                foreach ($optionalKeys as $key) {
                    if (!array_key_exists($key, $data)) {
                        $data[$key] = null;
                    }
                }

                $validator = Validator::make($data, [
                    'name'                => 'required|string|max:255',
                    'nik'                 => 'required|string|size:16',
                    'email'               => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
                    'phone'               => 'required|string|max:20',
                    'education'           => 'required|in:S3,S2,S1,D4,D3,SMA',
                    'category'            => 'required|in:guru,mahasiswa,kerja',
                    'company'             => 'nullable|string|max:255',
                    'position'            => 'nullable|string|max:255',
                    'training_program_id' => 'required|exists:training_programs,id',
                    'payment_method'      => 'nullable|string|max:100',
                    'payment_status'      => 'nullable|in:PENDING,SETTLED,EXPIRED',
                    'payment_amount'      => 'nullable|numeric',
                    'status'              => 'nullable|in:PENDING,VERIFIED,LULUS'
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // If payment amount is empty, get from program price
                $amount = $data['payment_amount'];
                if (empty($amount)) {
                    $prog = TrainingProgram::find($data['training_program_id']);
                    if ($prog) {
                        // Extract number from price string like "Rp 1.500.000"
                        $cleanPrice = preg_replace('/[^0-9]/', '', $prog->price);
                        $amount = intval($cleanPrice) ?: 0;
                    } else {
                        $amount = 0;
                    }
                }

                TraineeEnrollment::updateOrCreate(
                    ['email' => $data['email'], 'training_program_id' => $data['training_program_id']],
                    [
                        'name' => $data['name'],
                        'nik' => $data['nik'],
                        'phone' => $data['phone'],
                        'education' => $data['education'],
                        'category' => $data['category'],
                        'company' => $data['company'] ?? '-',
                        'position' => $data['position'] ?? '-',
                        'payment_method' => $data['payment_method'] ?? 'Bank Transfer (Virtual Account)',
                        'payment_status' => $data['payment_status'] ?? 'PENDING',
                        'payment_reference' => $data['payment_reference'] ?? 'TRX-' . strtoupper(Str::random(10)),
                        'payment_amount' => $amount,
                        'status' => $data['status'] ?? 'PENDING'
                    ]
                );
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount pendaftaran peserta berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // INSTRUKTUR (CSV IMPORT/EXPORT)
    // ────────────────────────────────────────────────────────────────────────

    public function exportInstrukturs()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="instrukturs_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['username', 'email', 'name', 'password_plain'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $users = User::where('role', 'instruktur')->get();
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->username,
                    $user->email,
                    $user->name ?? $user->username,
                    $user->password_plain ?? 'password123'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importInstrukturs(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['username', 'email'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue;
                }
                
                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                foreach (['name', 'password_plain'] as $key) {
                    if (!array_key_exists($key, $data)) {
                        $data[$key] = null;
                    }
                }

                $validator = Validator::make($data, [
                    'username' => 'required|string|max:255',
                    'email'    => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $password = $data['password_plain'] ?? 'password123';
                $existingUser = User::where('email', $data['email'])->orWhere('username', $data['username'])->first();

                if ($existingUser) {
                    $existingUser->update([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => 'instruktur',
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                } else {
                    User::create([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => 'instruktur',
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                }
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount data instruktur berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // ASESOR (CSV IMPORT/EXPORT)
    // ────────────────────────────────────────────────────────────────────────

    public function exportAsesors()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="asesors_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['username', 'email', 'name', 'password_plain'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $users = User::where('role', 'asesor')->get();
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->username,
                    $user->email,
                    $user->name ?? $user->username,
                    $user->password_plain ?? 'password123'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importAsesors(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['username', 'email'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue;
                }
                
                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                foreach (['name', 'password_plain'] as $key) {
                    if (!array_key_exists($key, $data)) {
                        $data[$key] = null;
                    }
                }

                $validator = Validator::make($data, [
                    'username' => 'required|string|max:255',
                    'email'    => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $password = $data['password_plain'] ?? 'password123';
                $existingUser = User::where('email', $data['email'])->orWhere('username', $data['username'])->first();

                if ($existingUser) {
                    $existingUser->update([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => 'asesor',
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                } else {
                    User::create([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => 'asesor',
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                }
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount data asesor berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // ASESI (CSV IMPORT/EXPORT)
    // ────────────────────────────────────────────────────────────────────────

    public function exportAsesis()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="asesis_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['username', 'email', 'name', 'password_plain'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $users = User::where('role', 'asesi')->get();
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->username,
                    $user->email,
                    $user->name ?? $user->username,
                    $user->password_plain ?? 'password123'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importAsesis(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['username', 'email'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue;
                }
                
                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                foreach (['name', 'password_plain'] as $key) {
                    if (!array_key_exists($key, $data)) {
                        $data[$key] = null;
                    }
                }

                $validator = Validator::make($data, [
                    'username' => 'required|string|max:255',
                    'email'    => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $password = $data['password_plain'] ?? 'password123';
                $existingUser = User::where('email', $data['email'])->orWhere('username', $data['username'])->first();

                if ($existingUser) {
                    $existingUser->update([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => 'asesi',
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                } else {
                    User::create([
                        'name' => $data['name'] ?? $data['username'],
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'role' => 'asesi',
                        'password' => Hash::make($password),
                        'password_plain' => $password
                    ]);
                }
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount data asesi berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // CLASS SCHEDULES (CSV IMPORT/EXPORT)
    // ────────────────────────────────────────────────────────────────────────

    public function exportSchedules()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="schedules_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['training_program_id', 'asesor_id', 'asesor_email', 'topic', 'scheduled_at', 'location'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $schedules = \App\Models\ClassSchedule::with('instructor')->get();
            foreach ($schedules as $sched) {
                fputcsv($file, [
                    $sched->training_program_id,
                    $sched->asesor_id,
                    $sched->instructor->email ?? '',
                    $sched->topic,
                    $sched->scheduled_at ? $sched->scheduled_at->format('Y-m-d H:i:s') : '',
                    $sched->location
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importSchedules(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['training_program_id', 'topic', 'scheduled_at'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue;
                }
                
                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                $validator = Validator::make($data, [
                    'training_program_id' => 'required|exists:training_programs,id',
                    'topic'               => 'required|string|max:255',
                    'scheduled_at'        => 'required|date',
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Resolve Asesor ID
                $asesorId = $data['asesor_id'] ?? null;
                if (empty($asesorId) && !empty($data['asesor_email'])) {
                    $asesorUser = User::where('email', $data['asesor_email'])->first();
                    if ($asesorUser) {
                        $asesorId = $asesorUser->id;
                    }
                }

                if (empty($asesorId)) {
                    $asesorUser = User::whereIn('role', ['asesor', 'superadmin', 'admin', 'instruktur'])->first();
                    $asesorId = $asesorUser ? $asesorUser->id : null;
                }

                \App\Models\ClassSchedule::create([
                    'training_program_id' => $data['training_program_id'],
                    'asesor_id'           => $asesorId,
                    'topic'               => $data['topic'],
                    'scheduled_at'        => $data['scheduled_at'],
                    'location'            => $data['location'] ?? 'Online Class'
                ]);
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount jadwal kelas berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // ASSESSMENT SCHEMES (CSV IMPORT/EXPORT)
    // ────────────────────────────────────────────────────────────────────────

    public function exportSchemes()
    {
        $this->checkAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="schemes_export_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['title', 'description', 'asesor_id', 'asesor_email', 'status', 'duration_minutes'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $schemes = \App\Models\AssessmentScheme::with('asesor')->get();
            foreach ($schemes as $sch) {
                fputcsv($file, [
                    $sch->title,
                    $sch->description,
                    $sch->asesor_id,
                    $sch->asesor->email ?? '',
                    $sch->status,
                    $sch->duration_minutes
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importSchemes(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'csv_file' => 'required|file'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            
            if ($header) {
                $header[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $header[0]);
                $header = array_map('trim', $header);
            }

            $requiredHeaders = ['title', 'duration_minutes'];
            foreach ($requiredHeaders as $req) {
                if (!in_array($req, $header)) {
                    fclose($handle);
                    return redirect()->back()->with('error', "Format CSV salah. Kolom '$req' wajib ada.");
                }
            }

            $successCount = 0;
            $errorRows = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                if (count($row) < count($header)) {
                    continue;
                }
                
                $data = array_combine($header, array_slice($row, 0, count($header)));
                $data = array_map('trim', $data);

                $validator = Validator::make($data, [
                    'title'            => 'required|string|max:255',
                    'duration_minutes' => 'required|integer|min:1',
                ]);

                if ($validator->fails()) {
                    $errorRows[] = "Baris $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Resolve Asesor ID
                $asesorId = $data['asesor_id'] ?? null;
                if (empty($asesorId) && !empty($data['asesor_email'])) {
                    $asesorUser = User::where('email', $data['asesor_email'])->first();
                    if ($asesorUser) {
                        $asesorId = $asesorUser->id;
                    }
                }

                if (empty($asesorId)) {
                    $asesorUser = User::whereIn('role', ['asesor', 'superadmin', 'admin'])->first();
                    $asesorId = $asesorUser ? $asesorUser->id : null;
                }

                \App\Models\AssessmentScheme::create([
                    'title'            => $data['title'],
                    'description'      => $data['description'] ?? '',
                    'asesor_id'        => $asesorId,
                    'status'           => $data['status'] ?? 'published',
                    'duration_minutes' => $data['duration_minutes']
                ]);
                $successCount++;
            }
            fclose($handle);

            $msg = "$successCount skema ujian berhasil diimpor.";
            if (count($errorRows) > 0) {
                $msg .= " Beberapa baris dilewati:\n" . implode("\n", array_slice($errorRows, 0, 5));
                return redirect()->back()->with('success', $msg);
            }

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal membaca berkas CSV.');
    }
}
