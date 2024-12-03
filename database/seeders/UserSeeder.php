<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate(
            [
                'name' => 'administrator'
            ],
            [
                'name' => 'administrator'
            ]);
        $user = User::updateOrCreate([
            'login' => 'admin'
        ],[
            'name' => 'Administrator',
            'login' => 'admin',
            'password' => 'navqiron2024'
        ]);

        $user->assignRole($role);
    }
}
