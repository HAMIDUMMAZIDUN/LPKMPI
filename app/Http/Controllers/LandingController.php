<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use App\Models\LandingSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Redirect authenticated users to their role-specific dashboard (unless in preview mode)
        if (Auth::check() && !$request->has('preview')) {
            $role = Auth::user()->role;
            return match($role) {
                'superadmin' => redirect()->route('superadmin.dashboard'),
                'admin'      => redirect()->route('admin.dashboard'),
                'asesor'     => redirect()->route('asesor.dashboard'),
                'asesi'      => redirect()->route('asesi.dashboard'),
                default      => $this->renderLanding(),
            };
        }

        return $this->renderLanding();
    }

    public function pendaftaran()
    {
        $programs = TrainingProgram::all();
        $settings = LandingSetting::pluck('value', 'key');
        $siteTitle = LandingSetting::getValue('site_title', 'LPK-MI');
        $siteLogo  = LandingSetting::getValue('site_logo');
        return view('pendaftaran', compact('programs', 'settings', 'siteTitle', 'siteLogo'));
    }

    public function verifyCertificate(Request $request)
    {
        $number = $request->query('number');
        if (empty($number)) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor sertifikat wajib diisi.'
            ], 400);
        }

        $trainee = \App\Models\TraineeEnrollment::with('trainingProgram')
            ->where('certificate_number', 'LIKE', '%' . $number . '%')
            ->where('status', 'LULUS')
            ->first();

        if (!$trainee) {
            return response()->json([
                'success' => false,
                'message' => 'Sertifikat tidak ditemukan atau tidak valid.'
            ], 404);
        }

        // Mask NIK for security
        $nik = $trainee->nik;
        if (strlen($nik) >= 12) {
            $maskedNik = substr($nik, 0, 6) . '******' . substr($nik, -4);
        } else {
            $maskedNik = str_repeat('*', strlen($nik));
        }

        return response()->json([
            'success' => true,
            'certificate' => [
                'number' => $trainee->certificate_number,
                'date' => $trainee->certificate_date ? date('d F Y', strtotime($trainee->certificate_date)) : '-',
                'name' => strtoupper($trainee->name),
                'nik' => $maskedNik,
                'program' => $trainee->trainingProgram->title,
                'status' => 'KOMPETEN (LULUS)'
            ]
        ]);
    }

    private function renderLanding()
    {
        $programs = TrainingProgram::all();
        $settings = LandingSetting::pluck('value', 'key');

        // Landing settings with fallback defaults
        $heroTitle    = LandingSetting::getValue('hero_title',    'Persiapkan Kompetensi Anda Untuk Sertifikasi Profesional');
        $heroSubtitle = LandingSetting::getValue('hero_subtitle', 'LPK-MI membantu calon asesi, guru, dosen, dan praktisi menguasai standar kompetensi nasional sebelum menempuh ujian sertifikasi resmi di LSP.');
        $heroImage    = LandingSetting::getValue('hero_image');

        $statCount = (int) LandingSetting::getValue('stat_count', 3);
        $stats = [];
        for ($i = 1; $i <= $statCount; $i++) {
            $stats[] = [
                'val' => LandingSetting::getValue("stat_{$i}_val", $i == 1 ? '98%' : ($i == 2 ? '12+' : ($i == 3 ? '2.5k+' : '0'))),
                'lbl' => LandingSetting::getValue("stat_{$i}_lbl", $i == 1 ? 'Kelulusan LSP' : ($i == 2 ? 'Program Unggulan' : ($i == 3 ? 'Alumni' : 'Statistik Baru'))),
            ];
        }

        $stepCount = (int) LandingSetting::getValue('step_count', 3);
        $steps = [];
        for ($i = 1; $i <= $stepCount; $i++) {
            $steps[] = [
                'title' => LandingSetting::getValue("step_{$i}_title", $i == 1 ? 'Pelatihan LPK' : ($i == 2 ? 'Sertifikat LPK' : ($i == 3 ? 'Sertifikasi LSP' : "Langkah {$i}"))),
            ];
        }

        $whyChooseTitle = LandingSetting::getValue('why_choose_title', 'Mengapa Memilih LPK-MI?');
        $featureCount = (int) LandingSetting::getValue('feature_count', 3);
        $features = [];
        for ($i = 1; $i <= $featureCount; $i++) {
            $features[] = [
                'title' => LandingSetting::getValue("feature_{$i}_title", $i == 1 ? 'Instruktur Praktisi' : ($i == 2 ? 'Kurikulum Sinkron LSP' : ($i == 3 ? 'Sertifikat Terverifikasi' : "Fitur {$i}"))),
                'desc'  => LandingSetting::getValue("feature_{$i}_desc", $i == 1 ? 'Belajar langsung dari asesor kompetensi aktif dan praktisi berpengalaman di bidangnya.' : ($i == 2 ? 'Silabus materi pelatihan disesuaikan 100% dengan skema SKKNI pada LSPMI mitra.' : ($i == 3 ? 'Lulusan mendapatkan sertifikat digital dengan QR Code unik yang terintegrasi langsung dengan database LSP.' : 'Deskripsi fitur baru.'))),
            ];
        }

        // Guest-only data (not needed anymore since auth users are redirected)
        $trainees          = collect();
        $traineesCount     = 0;
        $certificatesCount = 0;
        $apiHitsCount      = 0;
        $users             = collect();
        
        $articles = \App\Models\Article::latest()->get();

        return view('landing', compact(
            'programs', 'trainees', 'traineesCount', 'certificatesCount', 'apiHitsCount', 'users',
            'heroTitle', 'heroSubtitle', 'heroImage',
            'stats', 'steps', 'whyChooseTitle', 'features',
            'settings', 'articles'
        ));
    }

    public function storeGuestBook(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'institution' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'purpose' => 'required|string',
            'meet_with' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $guestBook = \App\Models\GuestBook::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku tamu berhasil diisi.',
            'data' => $guestBook
        ]);
    }

    public function getGuestBooks()
    {
        $guests = \App\Models\GuestBook::latest()->take(5)->get()->map(function($guest) {
            $phone = $guest->phone;
            if (strlen($phone) >= 8) {
                $maskedPhone = substr($phone, 0, 4) . str_repeat('*', strlen($phone) - 6) . substr($phone, -2);
            } else {
                $maskedPhone = str_repeat('*', strlen($phone));
            }
            return [
                'name' => $guest->name,
                'phone' => $maskedPhone,
                'institution' => $guest->institution,
                'position' => $guest->position,
                'purpose' => $guest->purpose,
                'meet_with' => $guest->meet_with,
                'time' => $guest->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $guests
        ]);
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'contact_name'    => 'required|string|max:255',
            'contact_email'   => 'required|email|max:255',
            'contact_message' => 'required|string',
        ]);

        // Simulating the actual sending of an email by logging to Laravel logs
        \Illuminate\Support\Facades\Log::info("Mailable Sim: Contact message from " . $validated['contact_name'] . " (" . $validated['contact_email'] . "): " . $validated['contact_message']);

        // We could also send a real mail here in production:
        // \Illuminate\Support\Facades\Mail::raw($validated['contact_message'], function($message) use ($validated) {
        //     $message->to('admin@lpk-mpi.org')
        //             ->subject('Pesan Kontak Baru dari ' . $validated['contact_name'])
        //             ->from($validated['contact_email']);
        // });

        return response()->json([
            'success' => true,
            'message' => 'Pesan mailable Anda telah terkirim ke Admin!'
        ]);
    }

    public function sendChatMessage(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'message'    => 'required|string',
        ]);

        $lastMessage = \App\Models\ChatMessage::where('session_id', $validated['session_id'])
            ->whereNotNull('claimed_by_admin_id')
            ->latest()
            ->first();
        
        $claimedBy = $lastMessage ? $lastMessage->claimed_by_admin_id : null;

        $chatMessage = \App\Models\ChatMessage::create([
            'session_id'          => $validated['session_id'],
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'message'             => $validated['message'],
            'sender_role'         => 'visitor',
            'claimed_by_admin_id' => $claimedBy,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan terkirim!',
            'data'    => $chatMessage
        ]);
    }

    public function getChatMessages(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (empty($sessionId)) {
            return response()->json(['success' => false, 'messages' => []], 400);
        }

        $messages = \App\Models\ChatMessage::with('claimedByAdmin')
            ->where('session_id', $sessionId)
            ->oldest()
            ->get()
            ->map(function($msg) {
                return [
                    'id'          => $msg->id,
                    'message'     => $msg->message,
                    'sender_role' => $msg->sender_role,
                    'admin_name'  => $msg->claimedByAdmin ? $msg->claimedByAdmin->name : null,
                    'time'        => $msg->created_at->format('H:i'),
                ];
            });

        $claimedAdmin = null;
        $lastClaimed = \App\Models\ChatMessage::where('session_id', $sessionId)
            ->whereNotNull('claimed_by_admin_id')
            ->with('claimedByAdmin')
            ->latest()
            ->first();
        if ($lastClaimed && $lastClaimed->claimedByAdmin) {
            $claimedAdmin = $lastClaimed->claimedByAdmin->name;
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'claimed_by' => $claimedAdmin,
        ]);
    }
}
