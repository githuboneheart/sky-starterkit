<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StarterkitTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk ke Dashboard');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@starterkit.test',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_dashboard_can_be_visited_by_authenticated_user(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang Kembali');
    }

    public function test_admin_can_access_user_management(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();

        $response = $this->actingAs($admin)->get('/users');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna');
    }

    public function test_admin_can_access_permission_matrix(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();

        $response = $this->actingAs($admin)->get('/permissions');
        $response->assertStatus(200);
        $response->assertSee('Permission Matrix');
    }

    public function test_admin_can_access_settings(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();

        $response = $this->actingAs($admin)->get('/settings');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan');
    }

    public function test_super_admin_can_impersonate_and_leave(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();
        $staff = User::where('email', 'staff@starterkit.test')->first();

        // 1. Impersonate
        $response = $this->actingAs($admin)->post(route('impersonate', $staff));
        $response->assertRedirect('/dashboard');
        $this->assertEquals(auth()->id(), $staff->id);
        $this->assertEquals(session('impersonated_by_id'), $admin->id);

        // 2. Leave Impersonation
        $leaveResponse = $this->post(route('impersonate.leave'));
        $leaveResponse->assertRedirect(route('users.index'));
        $this->assertEquals(auth()->id(), $admin->id);
        $this->assertNull(session('impersonated_by_id'));
    }

    public function test_custom_404_error_page_renders_correctly(): void
    {
        $response = $this->get('/non-existent-url-testing-404');
        $response->assertStatus(404);
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('ERROR 404');
        $response->assertSee('Kembali ke Sebelumnya');
    }
}
