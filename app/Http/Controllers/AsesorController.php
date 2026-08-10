<?php

namespace App\Http\Controllers;

use App\Models\AssessmentScheme;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\ClassSchedule;
use App\Models\TrainingProgram;
use App\Models\AsesiSchemeAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AsesorController extends Controller
{
    private function checkRole()
    {
        if (auth()->user()->role !== 'asesor') {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {
        $this->checkRole();
        $schemes = AssessmentScheme::where('asesor_id', auth()->id())
            ->withCount('questions')
            ->latest()
            ->get();

        $schemeIds = $schemes->pluck('id');

        $attempts = AsesiSchemeAttempt::whereIn('scheme_id', $schemeIds)
            ->with(['asesi', 'scheme'])
            ->latest()
            ->get();

        $schedules = ClassSchedule::where('asesor_id', auth()->id())
            ->with('trainingProgram')
            ->latest()
            ->get();

        $programs = TrainingProgram::all();

        return view('dashboard.asesor', compact('schemes', 'attempts', 'schedules', 'programs'));
    }

    /** Live stats JSON – polled every 30 s by the dashboard */
    public function stats()
    {
        $this->checkRole();
        $mySchemes = AssessmentScheme::where('asesor_id', auth()->id());
        return response()->json([
            'schemes'    => $mySchemes->count(),
            'published'  => $mySchemes->clone()->where('status', 'published')->count(),
            'schedules'  => ClassSchedule::where('asesor_id', auth()->id())->count(),
            'attempts'   => AsesiSchemeAttempt::whereIn('scheme_id', AssessmentScheme::where('asesor_id', auth()->id())->pluck('id'))->count(),
            'ts'         => now()->toDateTimeString(),
        ]);
    }

    /** Simpan skema baru */
    public function storeScheme(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5',
        ]);

        $scheme = AssessmentScheme::create([
            'title'            => $request->title,
            'description'      => $request->description,
            'asesor_id'        => auth()->id(),
            'duration_minutes' => $request->duration_minutes,
            'status'           => 'draft',
        ]);

        return redirect()->route('asesor.scheme.edit', $scheme->id)->with('success', 'Skema berhasil dibuat! Tambahkan soal sekarang.');
    }

    /** Halaman edit skema + soal */
    public function editScheme($id)
    {
        $this->checkRole();
        $scheme = AssessmentScheme::where('asesor_id', auth()->id())->with(['questions.options'])->findOrFail($id);
        return view('asesor.scheme_edit', compact('scheme'));
    }

    /** Update detail skema */
    public function updateScheme(Request $request, $id)
    {
        $this->checkRole();
        $scheme = AssessmentScheme::where('asesor_id', auth()->id())->findOrFail($id);
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5',
        ]);
        $scheme->update($request->only('title', 'description', 'duration_minutes'));
        return redirect()->route('asesor.scheme.edit', $scheme->id)->with('success', 'Skema diperbarui!');
    }

    /** Publish / Unpublish skema */
    public function togglePublish($id)
    {
        $this->checkRole();
        $scheme = AssessmentScheme::where('asesor_id', auth()->id())->findOrFail($id);

        if ($scheme->status === 'draft') {
            if ($scheme->questions()->count() === 0) {
                return redirect()->back()->with('error', 'Skema harus memiliki minimal 1 soal sebelum dipublikasikan.');
            }
            $scheme->update(['status' => 'published']);
            $msg = 'Skema berhasil dipublikasikan! Asesi sekarang dapat mengerjakan skema ini.';
        } else {
            $scheme->update(['status' => 'draft']);
            $msg = 'Skema dikembalikan ke draft.';
        }

        return redirect()->route('asesor.scheme.edit', $scheme->id)->with('success', $msg);
    }

    /** Hapus skema */
    public function deleteScheme($id)
    {
        $this->checkRole();
        $scheme = AssessmentScheme::where('asesor_id', auth()->id())->findOrFail($id);
        $scheme->delete();
        return redirect()->route('asesor.dashboard')->with('success', 'Skema berhasil dihapus.');
    }

    /** Tambah soal ke skema */
    public function storeQuestion(Request $request, $schemeId)
    {
        $this->checkRole();
        $scheme = AssessmentScheme::where('asesor_id', auth()->id())->findOrFail($schemeId);

        $request->validate([
            'question_text'              => 'required|string',
            'question_type'              => 'required|in:multiple_choice,essay',
            'points'                     => 'required|integer|min:1',
            'options'                    => 'required_if:question_type,multiple_choice|array|min:2',
            'options.*'                  => 'required_if:question_type,multiple_choice|string',
            'correct_option'             => 'required_if:question_type,multiple_choice|integer',
        ]);

        $order = $scheme->questions()->max('order') + 1;
        $question = Question::create([
            'scheme_id'     => $scheme->id,
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'points'        => $request->points,
            'order'         => $order,
        ]);

        if ($request->question_type === 'multiple_choice' && $request->options) {
            foreach ($request->options as $i => $optText) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optText,
                    'is_correct'  => ($i == $request->correct_option),
                    'order'       => $i,
                ]);
            }
        }

        return redirect()->route('asesor.scheme.edit', $schemeId)->with('success', 'Soal berhasil ditambahkan!');
    }

    /** Hapus soal */
    public function deleteQuestion($schemeId, $questionId)
    {
        $this->checkRole();
        $scheme = AssessmentScheme::where('asesor_id', auth()->id())->findOrFail($schemeId);
        $question = Question::where('scheme_id', $scheme->id)->findOrFail($questionId);
        $question->delete();
        return redirect()->route('asesor.scheme.edit', $schemeId)->with('success', 'Soal berhasil dihapus.');
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

        return redirect()->route('asesor.dashboard')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /** Simpan jadwal kelas baru */
    public function storeSchedule(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'training_program_id' => 'required|exists:training_programs,id',
            'topic'               => 'required|string|max:255',
            'scheduled_at'        => 'required|date',
            'location'            => 'required|string|max:255',
        ]);

        ClassSchedule::create([
            'training_program_id' => $request->training_program_id,
            'asesor_id'           => auth()->id(),
            'topic'               => $request->topic,
            'scheduled_at'        => $request->scheduled_at,
            'location'            => $request->location,
        ]);

        return redirect()->route('asesor.dashboard', ['open' => 'panel-jadwal'])->with('success', 'Jadwal kelas baru berhasil ditambahkan!');
    }

    /** Update jadwal kelas */
    public function updateSchedule(Request $request, $id)
    {
        $this->checkRole();
        $schedule = ClassSchedule::where('asesor_id', auth()->id())->findOrFail($id);

        $request->validate([
            'training_program_id' => 'required|exists:training_programs,id',
            'topic'               => 'required|string|max:255',
            'scheduled_at'        => 'required|date',
            'location'            => 'required|string|max:255',
        ]);

        $schedule->update([
            'training_program_id' => $request->training_program_id,
            'topic'               => $request->topic,
            'scheduled_at'        => $request->scheduled_at,
            'location'            => $request->location,
        ]);

        return redirect()->route('asesor.dashboard', ['open' => 'panel-jadwal'])->with('success', 'Jadwal kelas berhasil diperbarui!');
    }

    /** Hapus jadwal kelas */
    public function destroySchedule($id)
    {
        $this->checkRole();
        $schedule = ClassSchedule::where('asesor_id', auth()->id())->findOrFail($id);
        $schedule->delete();

        return redirect()->route('asesor.dashboard', ['open' => 'panel-jadwal'])->with('success', 'Jadwal kelas berhasil dihapus.');
    }

    /** Update silabus/program deskripsi */
    public function updateSyllabus(Request $request, $id)
    {
        $this->checkRole();
        $program = TrainingProgram::findOrFail($id);
        
        $request->validate([
            'description' => 'required|string',
            'benefits'    => 'nullable|string',
        ]);

        // Process benefits line by line to array
        $benefitsArray = [];
        if ($request->filled('benefits')) {
            $benefitsArray = array_filter(array_map('trim', explode("\n", $request->benefits)));
        }

        $program->update([
            'description' => $request->description,
            'benefits'    => $benefitsArray,
        ]);

        return redirect()->route('asesor.dashboard', ['open' => 'panel-kelola'])->with('success', 'Silabus program ' . $program->title . ' berhasil diperbarui!');
    }
}
