<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TrainingProgram;
use App\Models\TraineeEnrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GoogleSsoAndImportExportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Google SSO Redirect.
     */
    public function test_google_sso_redirect_falls_back_to_mock_if_client_id_empty()
    {
        // Force config client_id to be empty
        config(['services.google.client_id' => '']);

        $response = $this->get(route('auth.google'));
        $response->assertRedirect(route('auth.mock-google'));
    }

    /**
     * Test Mock Google SSO Login Callback.
     */
    public function test_mock_google_sso_callback_authenticates_existing_user()
    {
        $user = User::create([
            'name' => 'LSP MPI Google',
            'username' => 'lsp_mpi',
            'email' => 'lspmanajemenpendidikanislam@gmail.com',
            'password' => bcrypt('secret123'),
            'role' => 'superadmin',
        ]);

        $response = $this->post(route('auth.mock-google-callback'), [
            'email' => 'lspmanajemenpendidikanislam@gmail.com',
        ]);

        $response->assertRedirect(route('superadmin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test CSV Export endpoints require auth and admin/superadmin roles.
     */
    public function test_export_endpoints_require_admin_or_superadmin()
    {
        // Unauthenticated -> redirected to login
        $this->get(route('export.users'))->assertRedirect(route('login'));

        // Authenticated as standard Asesi user -> 403 Forbidden
        $asesi = User::create([
            'name' => 'Asesi',
            'username' => 'asesi_user',
            'email' => 'asesi@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'asesi',
        ]);

        $this->actingAs($asesi);
        $this->get(route('export.users'))->assertStatus(403);
    }

    /**
     * Test Users CSV Export and Import.
     */
    public function test_users_csv_export_and_import()
    {
        $superadmin = User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'email' => 'lspmanajemenpendidikanislam@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
        ]);

        $this->actingAs($superadmin);

        // Export Users
        $response = $this->get(route('export.users'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $csvContent = $response->streamedContent();
        $this->assertStringContainsString('username,email,name,role,password_plain', $csvContent);

        // Import Users
        $csvData = "username,email,role,name,password_plain\n" .
                    "imported_admin,imported_admin@gmail.com,admin,Imported Admin,secret123\n" .
                    "imported_asesor,imported_asesor@gmail.com,asesor,Imported Asesor,secret123\n";

        $tempFile = UploadedFile::fake()->createWithContent('users_import.csv', $csvData);

        $importResponse = $this->post(route('import.users'), [
            'csv_file' => $tempFile,
        ]);

        $importResponse->assertRedirect();
        $this->assertDatabaseHas('users', [
            'username' => 'imported_admin',
            'email' => 'imported_admin@gmail.com',
            'role' => 'admin',
        ]);
        $this->assertDatabaseHas('users', [
            'username' => 'imported_asesor',
            'email' => 'imported_asesor@gmail.com',
            'role' => 'asesor',
        ]);
    }

    /**
     * Test Programs CSV Export and Import.
     */
    public function test_programs_csv_export_and_import()
    {
        $superadmin = User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'email' => 'lspmanajemenpendidikanislam@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
        ]);

        TrainingProgram::create([
            'id' => 'existing_prog',
            'title' => 'Existing Program',
            'category' => 'Umum',
            'price' => 'Rp 1.000.000',
            'duration' => '3 Hari',
            'description' => 'Existing program desc',
            'benefits' => ['Benefit 1'],
            'lsp_keyword' => 'test',
        ]);

        $this->actingAs($superadmin);

        // Export
        $response = $this->get(route('export.programs'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $csvContent = $response->streamedContent();
        $this->assertStringContainsString('id,title,category,duration,description,price,lsp_keyword,benefits', $csvContent);

        // Import
        $csvData = "id,title,category,price,duration,description,benefits,lsp_keyword\n" .
                    "new_prog,New Program Import,Umum,Rp 2.000.000,5 Hari,New imported program,benefit A|benefit B,test\n";

        $tempFile = UploadedFile::fake()->createWithContent('programs.csv', $csvData);

        $importResponse = $this->post(route('import.programs'), [
            'csv_file' => $tempFile,
        ]);

        $importResponse->assertRedirect();
        $this->assertDatabaseHas('training_programs', [
            'id' => 'new_prog',
            'title' => 'New Program Import',
        ]);
    }

    /**
     * Test Trainees CSV Export and Import.
     */
    public function test_trainees_csv_export_and_import()
    {
        $superadmin = User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'email' => 'lspmanajemenpendidikanislam@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
        ]);

        $program = TrainingProgram::create([
            'id' => 'existing_prog',
            'title' => 'Existing Program',
            'category' => 'Umum',
            'price' => 'Rp 1.000.000',
            'duration' => '3 Hari',
            'description' => 'Existing program desc',
            'benefits' => ['Benefit 1'],
            'lsp_keyword' => 'test',
        ]);

        TraineeEnrollment::create([
            'name' => 'John Doe',
            'nik' => '3201234567890123',
            'email' => 'johndoe@gmail.com',
            'phone' => '08123456789',
            'education' => 'S1',
            'category' => 'kerja',
            'company' => 'Google Inc',
            'position' => 'Developer',
            'training_program_id' => 'existing_prog',
            'status' => 'PENDING',
            'payment_status' => 'PENDING',
        ]);

        $this->actingAs($superadmin);

        // Export
        $response = $this->get(route('export.trainees'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $csvContent = $response->streamedContent();
        $this->assertStringContainsString('name,nik,email,phone,education', $csvContent);

        // Import
        $csvData = "name,nik,email,phone,education,category,company,position,training_program_id,status,payment_status\n" .
                    "Jane Doe,3201234567890124,janedoe@gmail.com,08123456780,S1,kerja,Apple Inc,Manager,existing_prog,PENDING,PENDING\n";

        $tempFile = UploadedFile::fake()->createWithContent('trainees.csv', $csvData);

        $importResponse = $this->post(route('import.trainees'), [
            'csv_file' => $tempFile,
        ]);

        $importResponse->assertRedirect();
        $this->assertDatabaseHas('trainee_enrollments', [
            'name' => 'Jane Doe',
            'nik' => '3201234567890124',
            'email' => 'janedoe@gmail.com',
        ]);
    }
}
