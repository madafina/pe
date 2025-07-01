<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleFinance = Role::create(['name' => 'finance']);
        $roleStudent = Role::create(['name' => 'student']);

        // (Opsional) Buat Permissions
        Permission::create(['name' => 'admin']);
        Permission::create(['name' => 'finance']);
        Permission::create(['name' => 'student']);
        $roleAdmin->givePermissionTo('admin');
        $roleFinance->givePermissionTo('finance');
        $roleStudent->givePermissionTo('student');

        // Tugaskan roles ke user yang sudah ada
        $adminUser = User::where('email', 'admin@bimbelpenaemas.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($roleAdmin);
        }

        $financeUser = User::where('email', 'finance@bimbelpenaemas.com')->first();
        if ($financeUser) {
            $financeUser->assignRole($roleFinance);
        }
    }
}