<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LandingSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LoginSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_default_branding_texts()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('LEMBAGA SERTIFIKASI');
        $response->assertSee('PROFESI');
        $response->assertSee('(lsp) p3');
        $response->assertSee('MANAJEMEN');
        $response->assertSee('PENDIDIKAN');
        $response->assertSee('ISLAM');
        $response->assertSee('SKKNI');
        $response->assertSee('Standar Kompetensi Kerja Khusus Manajemen Pendidikan Islam');
    }

    public function test_superadmin_can_update_login_settings_and_see_them_on_login_page()
    {
        Storage::fake('public');

        // Create Superadmin user
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
        ]);

        $this->actingAs($superadmin);

        // Submit setting update with custom values & mock bg image
        $fakeBgImage = UploadedFile::fake()->image('login-bg.jpg');

        $response = $this->post(route('superadmin.settings.update'), [
            'login_left_title_1' => 'LSP BARU 1',
            'login_left_title_2' => 'SERTIFIKAT BARU 2',
            'login_left_sub' => 'LSP INDONESIA',
            'login_left_main' => "MANAJEMEN\nMPI\nKREATIF",
            'login_left_footer_title' => 'STANDAR BARU',
            'login_left_footer_desc' => 'Deskripsi Standar Baru Kompetensi',
            'login_bg_image' => $fakeBgImage,
        ]);

        $response->assertRedirect(route('superadmin.dashboard'));

        // Assert database values
        $this->assertEquals('LSP BARU 1', LandingSetting::getValue('login_left_title_1'));
        $this->assertEquals('SERTIFIKAT BARU 2', LandingSetting::getValue('login_left_title_2'));
        $this->assertEquals('LSP INDONESIA', LandingSetting::getValue('login_left_sub'));
        $this->assertEquals("MANAJEMEN\nMPI\nKREATIF", LandingSetting::getValue('login_left_main'));
        $this->assertEquals('STANDAR BARU', LandingSetting::getValue('login_left_footer_title'));
        $this->assertEquals('Deskripsi Standar Baru Kompetensi', LandingSetting::getValue('login_left_footer_desc'));

        // Assert background image saved to public disk
        $savedBgPath = LandingSetting::getValue('login_bg_image');
        $this->assertNotEmpty($savedBgPath);
        Storage::disk('public')->assertExists($savedBgPath);

        // Logout superadmin to load guest login page
        $this->post(route('logout'));

        // Visit login page again and assert new contents are shown
        $loginResponse = $this->get(route('login'));
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('LSP BARU 1');
        $loginResponse->assertSee('SERTIFIKAT BARU 2');
        $loginResponse->assertSee('LSP INDONESIA');
        $loginResponse->assertSee('MANAJEMEN');
        $loginResponse->assertSee('MPI');
        $loginResponse->assertSee('KREATIF');
        $loginResponse->assertSee('STANDAR BARU');
        $loginResponse->assertSee('Deskripsi Standar Baru Kompetensi');
        
        // Assert the background image asset url is embedded in the style tag
        $loginResponse->assertSee(asset('storage/' . $savedBgPath));
    }

    public function test_user_can_login_manually_with_correct_credentials()
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'username' => 'adminuser',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'username' => 'adminuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_manually_with_incorrect_credentials()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'username' => 'adminuser',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'username' => 'adminuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_superadmin_can_create_new_users()
    {
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
        ]);

        $this->actingAs($superadmin);

        $response = $this->post(route('superadmin.user.store'), [
            'username' => 'new_admin',
            'email' => 'new_admin@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('superadmin.dashboard', ['open' => 'panel-users']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => 'new_admin',
            'email' => 'new_admin@gmail.com',
            'role' => 'admin',
        ]);

        // Try logging in with the newly created admin account
        $this->post(route('logout'));
        $loginResponse = $this->post('/login', [
            'username' => 'new_admin',
            'password' => 'password123',
        ]);
        $loginResponse->assertRedirect(route('admin.dashboard'));
    }

    public function test_superadmin_cannot_create_new_user_with_non_gmail_email()
    {
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
        ]);

        $this->actingAs($superadmin);

        $response = $this->post(route('superadmin.user.store'), [
            'username' => 'new_admin',
            'email' => 'new_admin@yahoo.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'username' => 'new_admin',
        ]);
    }
}
