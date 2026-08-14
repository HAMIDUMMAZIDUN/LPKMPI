<?php

namespace Tests\Feature;

use App\Models\TrainingProgram;
use App\Models\TraineeEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TraineeEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    private $program;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default program for testing
        $this->program = TrainingProgram::create([
            'id' => 'mpi_test_prog',
            'title' => 'Program Sertifikasi MPI',
            'category' => 'Kategori Madrasah',
            'duration' => '40 JP',
            'description' => 'Mempersiapkan kompetensi pedagogik kepala madrasah.',
            'benefits' => ['Sertifikat'],
            'price' => 'Rp 500.000',
            'lsp_keyword' => 'Ibtidaiyah',
        ]);
    }

    public function test_cannot_request_otp_with_non_gmail_email()
    {
        $response = $this->postJson(route('enroll.send-otp'), [
            'email' => 'user@yahoo.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
        $this->assertEquals(
            'Alamat email harus menggunakan domain @gmail.com.',
            $response->json('errors.email.0')
        );
    }

    public function test_can_request_otp_with_gmail_email()
    {
        $response = $this->postJson(route('enroll.send-otp'), [
            'email' => 'user.test@gmail.com',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Kode verifikasi telah dikirim ke email Anda.',
        ]);

        // Check if OTP code is generated in session
        $this->assertTrue(session()->has('otp_user.test@gmail.com'));
    }

    public function test_cannot_enroll_with_non_gmail_email()
    {
        $response = $this->postJson(route('enroll'), [
            'program_id' => $this->program->id,
            'name' => 'John Doe',
            'nik' => '1234567890123456',
            'email' => 'john.doe@hotmail.com',
            'phone' => '081234567890',
            'education' => 'S1',
            'category' => 'guru',
            'company' => 'Madrasah Aliyah',
            'position' => 'Guru MPI',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_can_enroll_successfully()
    {
        // Submit enrollment without OTP
        $response = $this->postJson(route('enroll'), [
            'program_id' => $this->program->id,
            'name' => 'John Doe',
            'nik' => '1234567890123456',
            'email' => 'john.doe@gmail.com',
            'phone' => '081234567890',
            'education' => 'S1',
            'category' => 'guru',
            'company' => 'Madrasah Aliyah',
            'position' => 'Guru MPI',
            'ktp' => UploadedFile::fake()->image('ktp.jpg'),
            'ijazah' => UploadedFile::fake()->image('ijazah.jpg'),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Pendaftaran awal berhasil, silakan lakukan pembayaran.',
        ]);

        // Check if database contains enrollment
        $this->assertDatabaseHas('trainee_enrollments', [
            'email' => 'john.doe@gmail.com',
            'name' => 'John Doe',
        ]);
    }

    public function test_admin_can_send_schedule_and_payment_info_email()
    {
        // Create an admin user
        $admin = \App\Models\User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create a trainee enrollment
        $trainee = TraineeEnrollment::create([
            'training_program_id' => $this->program->id,
            'name' => 'Jane Doe',
            'nik' => '9876543210987654',
            'email' => 'jane.doe@gmail.com',
            'phone' => '089876543210',
            'education' => 'S1',
            'category' => 'guru',
            'company' => 'Madrasah',
            'position' => 'Guru',
            'payment_status' => 'UNPAID',
            'status' => 'MENUNGGU UJIAN',
        ]);

        // Perform request
        $response = $this->actingAs($admin)
            ->post(route('admin.trainees.send-schedule', $trainee->id), [
                'schedule_time' => 'Senin, 17 Agustus 2026 jam 09:00 WIB',
                'bank_info' => 'Bank Mandiri Rek. 131-00-2244668-8 a/n LPK MPI',
            ]);

        $response->assertRedirect(route('admin.dashboard', ['open' => 'panel-trainees-db']));
        $response->assertSessionHas('success');

        // Assert mail was sent
        $messages = app('mailer')->getSymfonyTransport()->messages();
        $this->assertCount(1, $messages);
        
        $email = $messages->first()->getOriginalMessage();
        $this->assertEquals('jane.doe@gmail.com', $email->getTo()[0]->getAddress());
        $this->assertEquals('Jadwal Pelatihan & Informasi Pembayaran - LPK MPI', $email->getSubject());
        $this->assertStringContainsString('Senin, 17 Agustus 2026 jam 09:00 WIB', $email->getTextBody());
        $this->assertStringContainsString('Bank Mandiri Rek. 131-00-2244668-8 a/n LPK MPI', $email->getTextBody());
    }

    public function test_admin_can_bulk_verify_payment()
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $t1 = TraineeEnrollment::create([
            'training_program_id' => $this->program->id,
            'name' => 'Jane Doe 1',
            'nik' => '9876543210987651',
            'email' => 'jane1@gmail.com',
            'phone' => '089876543211',
            'education' => 'S1',
            'category' => 'guru',
            'company' => 'Madrasah',
            'position' => 'Guru',
            'payment_status' => 'UNPAID',
            'status' => 'MENUNGGU UJIAN',
        ]);

        $t2 = TraineeEnrollment::create([
            'training_program_id' => $this->program->id,
            'name' => 'Jane Doe 2',
            'nik' => '9876543210987652',
            'email' => 'jane2@gmail.com',
            'phone' => '089876543212',
            'education' => 'S1',
            'category' => 'guru',
            'company' => 'Madrasah',
            'position' => 'Guru',
            'payment_status' => 'UNPAID',
            'status' => 'MENUNGGU UJIAN',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.trainees.bulk-verify'), [
                'ids' => [$t1->id, $t2->id]
            ]);

        $response->assertRedirect(route('admin.dashboard', ['open' => 'panel-verifikasi']));
        $response->assertSessionHas('success');

        $this->assertEquals('PAID', $t1->fresh()->payment_status);
        $this->assertEquals('PAID', $t2->fresh()->payment_status);
    }

    public function test_admin_can_bulk_delete_trainees()
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test3',
            'email' => 'admin3@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $t1 = TraineeEnrollment::create([
            'training_program_id' => $this->program->id,
            'name' => 'Jane Doe 1',
            'nik' => '9876543210987651',
            'email' => 'jane1@gmail.com',
            'phone' => '089876543211',
            'education' => 'S1',
            'category' => 'guru',
            'company' => 'Madrasah',
            'position' => 'Guru',
            'payment_status' => 'UNPAID',
            'status' => 'MENUNGGU UJIAN',
        ]);

        $t2 = TraineeEnrollment::create([
            'training_program_id' => $this->program->id,
            'name' => 'Jane Doe 2',
            'nik' => '9876543210987652',
            'email' => 'jane2@gmail.com',
            'phone' => '089876543212',
            'education' => 'S1',
            'category' => 'guru',
            'company' => 'Madrasah',
            'position' => 'Guru',
            'payment_status' => 'UNPAID',
            'status' => 'MENUNGGU UJIAN',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.trainees.bulk-delete'), [
                'ids' => [$t1->id, $t2->id]
            ]);

        $response->assertRedirect(route('admin.dashboard', ['open' => 'panel-verifikasi']));
        $response->assertSessionHas('success');

        $this->assertNull(TraineeEnrollment::find($t1->id));
        $this->assertNull(TraineeEnrollment::find($t2->id));
    }
}
