<?php

namespace Tests\Feature;

use App\Models\TrainingProgram;
use App\Models\TraineeEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
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
            'otp_code' => '123456',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_cannot_enroll_without_otp_code()
    {
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
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['otp_code']);
    }

    public function test_cannot_enroll_with_incorrect_otp_code()
    {
        // First send OTP to seed the session
        $this->postJson(route('enroll.send-otp'), [
            'email' => 'john.doe@gmail.com',
        ]);

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
            'otp_code' => '999999', // wrong OTP
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['otp_code']);
        $this->assertEquals(
            'Kode verifikasi salah atau telah kedaluwarsa.',
            $response->json('errors.otp_code.0')
        );
    }

    public function test_can_enroll_with_correct_otp_code()
    {
        // Request OTP
        $otpResponse = $this->postJson(route('enroll.send-otp'), [
            'email' => 'john.doe@gmail.com',
        ]);

        $otpCode = $otpResponse->json('debug_code');
        $this->assertNotEmpty($otpCode);

        // Submit enrollment with correct OTP
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
            'otp_code' => (string) $otpCode,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Pendaftaran berhasil!',
        ]);

        // Check if database contains enrollment
        $this->assertDatabaseHas('trainee_enrollments', [
            'email' => 'john.doe@gmail.com',
            'name' => 'John Doe',
        ]);

        // Check if OTP code is cleared from session
        $this->assertFalse(session()->has('otp_john.doe@gmail.com'));
    }
}
