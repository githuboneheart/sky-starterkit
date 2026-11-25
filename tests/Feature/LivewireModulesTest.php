<?php

namespace Tests\Feature;

use App\Livewire\PermissionMatrix;
use App\Livewire\SettingsManager;
use App\Livewire\UserManagement;
use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LivewireModulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_management_can_create_user_and_search(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();

        $this->actingAs($admin);

        Livewire::test(UserManagement::class)
            ->set('name', 'Operator Baru')
            ->set('email', 'operator.baru@starterkit.test')
            ->set('phone', '081299998888')
            ->set('role', 'Staff / Operator')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('save')
            ->assertDispatched('toast');

        $this->assertDatabaseHas('users', [
            'email' => 'operator.baru@starterkit.test',
            'name' => 'Operator Baru',
        ]);
    }

    public function test_user_management_can_assign_multiple_roles(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();
        $this->actingAs($admin);

        Livewire::test(UserManagement::class)
            ->set('name', 'Staf Multitalenta')
            ->set('email', 'multirole@starterkit.test')
            ->set('phone', '081233334444')
            ->set('selectedRoles', ['Manager', 'Staff / Operator'])
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('save')
            ->assertDispatched('toast');

        $user = User::where('email', 'multirole@starterkit.test')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('Manager'));
        $this->assertTrue($user->hasRole('Staff / Operator'));
    }

    public function test_user_management_can_confirm_and_impersonate(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();
        $staff = User::where('email', 'staff@starterkit.test')->first();
        $this->actingAs($admin);

        Livewire::test(UserManagement::class)
            ->call('confirmImpersonate', $staff->id)
            ->assertSet('showImpersonateModal', true)
            ->assertSet('impersonateUserId', $staff->id)
            ->call('impersonateUser')
            ->assertRedirect(route('dashboard'));

        $this->assertEquals(session('impersonated_by_id'), $admin->id);
        $this->assertEquals(Auth::id(), $staff->id);
    }

    public function test_permission_matrix_can_toggle_permission(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();
        $staffRole = Role::where('name', 'Staff / Operator')->first();

        $this->actingAs($admin);

        Livewire::test(PermissionMatrix::class, ['roleId' => $staffRole->id])
            ->call('togglePermission', 'settings.view')
            ->assertDispatched('toast');

        $staffRole->refresh();
        $this->assertTrue($staffRole->hasPermissionTo('settings.view'));
    }

    public function test_settings_manager_can_update_settings(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();

        $this->actingAs($admin);

        Livewire::test(SettingsManager::class)
            ->set('app_name', 'SKY Enterprise Core')
            ->set('company_name', 'SKY Technology Indonesia')
            ->call('saveGeneral')
            ->assertDispatched('toast');

        $this->assertEquals('SKY Enterprise Core', AppSetting::get('app_name'));
    }

    public function test_role_management_can_create_and_delete_role(): void
    {
        $admin = User::where('email', 'admin@starterkit.test')->first();

        $this->actingAs($admin);

        // Validation error on empty name
        Livewire::test(\App\Livewire\RoleManagement::class)
            ->set('newRoleName', '')
            ->call('createRole')
            ->assertHasErrors(['newRoleName']);

        // Success create role
        Livewire::test(\App\Livewire\RoleManagement::class)
            ->set('newRoleName', 'Koordinator Lapangan')
            ->call('createRole')
            ->assertHasNoErrors()
            ->assertDispatched('toast');

        $this->assertDatabaseHas('roles', [
            'name' => 'Koordinator Lapangan',
            'guard_name' => 'web',
        ]);

        $role = Role::where('name', 'Koordinator Lapangan')->first();

        // Delete role
        Livewire::test(\App\Livewire\RoleManagement::class)
            ->call('confirmDelete', $role->id)
            ->call('deleteRole')
            ->assertDispatched('toast');

        $this->assertDatabaseMissing('roles', [
            'name' => 'Koordinator Lapangan',
        ]);
    }
}
