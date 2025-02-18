<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage categories',
            'manage tools',
            'manage projects',
            'manage project tools',
            'manage wallets',
            'manage applicants',
            'apply job',
            'topup wallet',
            'withdraw wallet',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        $clientRole = Role::firstOrCreate([
            'name' => 'Client'
        ]);

        $clientPermissions = [
            'manage projects',
            'manage project tools',
            'manage applicants',
            'topup wallet',
            'withdraw wallet',
        ];

        $clientRole->syncPermissions($clientPermissions);

        $freelancerRole = Role::firstOrCreate([
            'name' => 'Freelancer'
        ]);

        $freelancerPermissions = [
            'apply job',
            'withdraw wallet',
        ];

        $freelancerRole->syncPermissions($freelancerPermissions);

        $superAdminRole = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@freelanco.com',
            'occupation' => 'Owner',
            'connect' => 999999,
            'avatar' => 'images/admin.png',
            'password' => bcrypt('freelanco1234'),
        ]);

        $user->assignRole($superAdminRole);

        $wallet = new Wallet([
            'balance' => 0,
        ]);

        $user->wallet()->save($wallet);
    }
}
