<?php

namespace Database\Seeders;

use App\Constants\PermissionConstant;
use App\Constants\SettingConstant;
use App\Models\Default\Permission;
use App\Models\Default\Role;
use App\Models\Default\Setting;
use App\Models\Default\User;
use App\Models\Store;
use App\Models\TypeStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SettingConstant::SYSTEM as $setting) {
            Setting::insert(['id' => Str::ulid(), ...$setting]);
        }

        foreach (PermissionConstant::LIST as $permission) {
            Permission::insert(['id' => Str::ulid(), ...$permission]);
        }

        foreach (['Order', 'Proses', 'Kirim', 'Selesai'] as $p) {
            TypeStatus::query()->create(['name' => $p]);
        }

        $cabang = Role::query()->create(['name' => 'toko cabang']);

        $permissions = Permission::query()
            ->where('name', '==', 'view-dashboard')
            ->orWhere('name', '==', 'view-order')
            ->get();

        foreach ($permissions as $permission) {
            $cabang->rolePermissions()->create(['permission_id' => $permission->id]);
        }

        $role = Role::query()->create(['name' => 'admin']);

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role->rolePermissions()->create(['permission_id' => $permission->id]);
        }

        $store = Store::query()->create(['name' => 'Pusat', 'city' => 'Yogyarkarta']);

        User::create([
            'name' => 'Super Administrator',
            'email' => 'root@admin.com',
            'password' => bcrypt('password'),
            'store_id' => $store->id,
        ]);

        User::create([
            'name' => 'Administator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);

        $store = Store::query()->create(['name' => 'Cabang', 'city' => 'Surabaya']);
        User::create([
            'name' => 'Cabang',
            'email' => 'cabang@admin.com',
            'password' => bcrypt('password'),
            'role_id' => $cabang->id,
            'store_id' => $store->id,
        ]);
    }
}
