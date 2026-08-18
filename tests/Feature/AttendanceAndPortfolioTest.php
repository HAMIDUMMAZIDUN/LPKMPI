<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TrainingProgram;
use App\Models\ClassSchedule;
use App\Models\TraineeEnrollment;
use App\Models\AsesiPortfolio;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttendanceAndPortfolioTest extends TestCase
{
    use RefreshDatabase;

    private $asesi;
    private $asesor;
    private $program;
    private $schedule;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create Training Program
        $this->program = TrainingProgram::create([
            'id' => 'test_prog',
            'title' => 'Test Training Program',
            'category' => 'Umum',
            'price' => 'Rp 1.000.000',
            'duration' => '3 Hari',
            'description' => 'Test description',
            'benefits' => ['Benefit 1'],
            'lsp_keyword' => 'test',
        ]);

        // Create Asesi User
        $this->asesi = User::create([
            'name' => 'Asesi Tester',
            'username' => 'asesi_tester',
            'email' => 'asesi.tester@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'asesi',
        ]);

        // Enroll Asesi to Training Program
        TraineeEnrollment::create([
            'name' => 'Asesi Tester',
            'email' => 'asesi.tester@gmail.com',
            'nik' => '1234567890123456',
            'phone' => '081234567890',
            'education' => 'S1',
            'category' => 'umum',
            'company' => 'Self',
            'position' => 'Student',
            'training_program_id' => 'test_prog',
            'status' => 'LULUS',
            'payment_status' => 'PAID',
        ]);

        // Create Asesor User
        $this->asesor = User::create([
            'name' => 'Asesor Tester',
            'username' => 'asesor_tester',
            'email' => 'asesor.tester@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'asesor',
        ]);

        // Create Class Schedule
        $this->schedule = ClassSchedule::create([
            'training_program_id' => 'test_prog',
            'instructor_id' => $this->asesor->id,
            'asesor_id' => $this->asesor->id,
            'topic' => 'Asesmen Mandiri APL-02',
            'location' => 'LPK Center',
            'scheduled_at' => now()->addDays(2),
        ]);
    }

    /**
     * Test server-side class attendance recording.
     */
    public function test_asesi_can_record_attendance()
    {
        $this->actingAs($this->asesi);

        $response = $this->postJson(route('asesi.attendance.record'), [
            'class_schedule_id' => $this->schedule->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Presensi berhasil dicatat!',
            ]);

        $this->assertDatabaseHas('attendances', [
            'user_id' => $this->asesi->id,
            'class_schedule_id' => $this->schedule->id,
            'status' => 'present',
        ]);
    }

    /**
     * Test portfolio document upload.
     */
    public function test_asesi_can_upload_portfolio()
    {
        $this->actingAs($this->asesi);

        $fakeFile = UploadedFile::fake()->create('cv_document.pdf', 500, 'application/pdf');

        $response = $this->post(route('asesi.portfolio.store'), [
            'training_program_id' => $this->program->id,
            'document_name' => 'Curriculum Vitae (CV)',
            'portfolio_file' => $fakeFile,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Dokumen portofolio berhasil diunggah!');

        // Check DB entry
        $this->assertDatabaseHas('asesi_portfolios', [
            'user_id' => $this->asesi->id,
            'training_program_id' => $this->program->id,
            'document_name' => 'Curriculum Vitae (CV)',
            'status' => 'pending',
        ]);

        // Check storage file
        $portfolio = AsesiPortfolio::first();
        Storage::disk('public')->assertExists($portfolio->file_path);
    }

    /**
     * Test portfolio document deletion.
     */
    public function test_asesi_can_delete_portfolio()
    {
        $this->actingAs($this->asesi);

        // Put a fake file on fake public storage
        $filePath = 'portfolios/' . $this->asesi->id . '/test_doc.pdf';
        Storage::disk('public')->put($filePath, 'fake content');

        $portfolio = AsesiPortfolio::create([
            'user_id' => $this->asesi->id,
            'training_program_id' => $this->program->id,
            'document_name' => 'Curriculum Vitae (CV)',
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        $response = $this->delete(route('asesi.portfolio.delete', $portfolio->id));

        $response->assertRedirect()
            ->assertSessionHas('success', 'Dokumen portofolio berhasil dihapus.');

        $this->assertDatabaseMissing('asesi_portfolios', [
            'id' => $portfolio->id,
        ]);

        Storage::disk('public')->assertMissing($filePath);
    }

    /**
     * Test asesor can review portfolio document.
     */
    public function test_asesor_can_review_portfolio()
    {
        $portfolio = AsesiPortfolio::create([
            'user_id' => $this->asesi->id,
            'training_program_id' => $this->program->id,
            'document_name' => 'Curriculum Vitae (CV)',
            'file_path' => 'portfolios/1/dummy.pdf',
            'status' => 'pending',
        ]);

        $this->actingAs($this->asesor);

        // Approve
        $response = $this->post(route('asesor.portfolio.review', $portfolio->id), [
            'status' => 'approved',
            'notes' => 'Dokumen lengkap dan absah',
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Dokumen portofolio disetujui!');

        $this->assertDatabaseHas('asesi_portfolios', [
            'id' => $portfolio->id,
            'status' => 'approved',
            'notes' => 'Dokumen lengkap dan absah',
        ]);

        // Reject
        $responseReject = $this->post(route('asesor.portfolio.review', $portfolio->id), [
            'status' => 'rejected',
            'notes' => 'Ijazah buram, harap unggah ulang scan resolusi tinggi',
        ]);

        $responseReject->assertRedirect()
            ->assertSessionHas('success', 'Dokumen portofolio ditolak.');

        $this->assertDatabaseHas('asesi_portfolios', [
            'id' => $portfolio->id,
            'status' => 'rejected',
            'notes' => 'Ijazah buram, harap unggah ulang scan resolusi tinggi',
        ]);
    }
}
