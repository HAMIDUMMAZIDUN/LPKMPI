<?php

namespace App\Http\Controllers;

use App\Models\AssessmentScheme;
use App\Models\AsesiAnswer;
use App\Models\AsesiSchemeAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AsesiController extends Controller
{
    private function checkRole()
    {
        if (!auth()->check() || auth()->user()->role !== 'asesi') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Asesi.');
        }
    }

    /** Dashboard asesi: list semua skema yang published */
    public function index()
    {
        $this->checkRole();

        $schemes = AssessmentScheme::where('status', 'published')
            ->with(['asesor'])
            ->withCount('questions')
            ->get();

        // Ambil attempt asesi ini untuk tiap skema
        $attempts = AsesiSchemeAttempt::where('asesi_id', auth()->id())
            ->get()
            ->keyBy('scheme_id');

        $userEmail = auth()->user()->email;
        
        $enrollments = \App\Models\TraineeEnrollment::where('email', $userEmail)
            ->with('trainingProgram')
            ->latest()
            ->get();

        $enrolledProgramIds = $enrollments->pluck('training_program_id');

        $schedules = \App\Models\ClassSchedule::whereIn('training_program_id', $enrolledProgramIds)
            ->with(['trainingProgram', 'instructor'])
            ->latest()
            ->get();

        return view('dashboard.asesi', compact('schemes', 'attempts', 'enrollments', 'schedules'));
    }

    /** Mulai mengerjakan skema */
    public function startScheme($schemeId)
    {
        $this->checkRole();

        $scheme = AssessmentScheme::where('status', 'published')
            ->with(['questions' => fn($q) => $q->orderBy('order'), 'questions.options' => fn($q) => $q->orderBy('order')])
            ->findOrFail($schemeId);

        // Jika sudah selesai, langsung tampilkan hasil
        $completed = AsesiSchemeAttempt::where('asesi_id', auth()->id())
            ->where('scheme_id', $schemeId)
            ->where('status', 'completed')
            ->first();

        if ($completed) {
            return redirect()->route('asesi.result', $completed->id);
        }

        // Ambil atau buat attempt in_progress (search only by asesi_id+scheme_id)
        $attempt = AsesiSchemeAttempt::firstOrCreate(
            ['asesi_id' => auth()->id(), 'scheme_id' => $schemeId],
            ['status' => 'in_progress', 'started_at' => now()]
        );

        // Load jawaban yang sudah pernah diisi
        $savedAnswers = AsesiAnswer::where('attempt_id', $attempt->id)
            ->get()
            ->keyBy('question_id');

        return view('asesi.exam', compact('scheme', 'attempt', 'savedAnswers'));
    }

    /** Simpan satu jawaban via AJAX */
    public function saveAnswer(Request $request, $attemptId)
    {
        $this->checkRole();

        $attempt = AsesiSchemeAttempt::where('asesi_id', auth()->id())
            ->where('status', 'in_progress')
            ->findOrFail($attemptId);

        $request->validate([
            'question_id'        => 'required|integer|exists:questions,id',
            'selected_option_id' => 'nullable|integer|exists:question_options,id',
            'essay_answer'       => 'nullable|string|max:5000',
        ]);

        AsesiAnswer::updateOrCreate(
            ['attempt_id' => $attempt->id, 'question_id' => $request->question_id],
            [
                'selected_option_id' => $request->selected_option_id ?? null,
                'essay_answer'       => $request->essay_answer ?? null,
            ]
        );

        return response()->json(['success' => true]);
    }

    /** Kumpulkan semua jawaban & hitung skor */
    public function finishScheme(Request $request, $attemptId)
    {
        $this->checkRole();

        $attempt = AsesiSchemeAttempt::where('asesi_id', auth()->id())
            ->where('status', 'in_progress')
            ->findOrFail($attemptId);

        // Simpan semua jawaban dari form
        $answers = $request->input('answers', []);
        foreach ($answers as $questionId => $data) {
            AsesiAnswer::updateOrCreate(
                ['attempt_id' => $attempt->id, 'question_id' => (int) $questionId],
                [
                    'selected_option_id' => isset($data['selected_option_id']) ? (int) $data['selected_option_id'] : null,
                    'essay_answer'       => $data['essay_answer'] ?? null,
                ]
            );
        }

        // Hitung skor (calculateScore loads fresh from DB)
        $score = $attempt->calculateScore();

        $attempt->update([
            'status'       => 'completed',
            'score'        => $score,
            'completed_at' => now(),
        ]);

        return redirect()->route('asesi.result', $attempt->id)
            ->with('success', 'Ujian berhasil diselesaikan! Nilai Anda: ' . $score . '%');
    }

    /** Halaman hasil ujian */
    public function result($attemptId)
    {
        $this->checkRole();

        $attempt = AsesiSchemeAttempt::where('asesi_id', auth()->id())
            ->with([
                'scheme.questions' => fn($q) => $q->orderBy('order'),
                'scheme.questions.options' => fn($q) => $q->orderBy('order'),
                'answers.selectedOption',
                'answers.question',
            ])
            ->findOrFail($attemptId);

        return view('asesi.result', compact('attempt'));
    }

    public function updateProfile(Request $request)
    {
        $this->checkRole();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'email'    => ['required', 'email', 'unique:users,email,' . auth()->id(), 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
        ]);

        $data = [
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        auth()->user()->update($data);

        return redirect()->route('asesi.dashboard')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /** Tampilkan sertifikat digital asesi */
    public function downloadCertificate($enrollmentId)
    {
        $this->checkRole();
        $enrollment = \App\Models\TraineeEnrollment::where('email', auth()->user()->email)
            ->where('status', 'LULUS')
            ->findOrFail($enrollmentId);

        return view('asesi.certificate', compact('enrollment'));
    }
}
