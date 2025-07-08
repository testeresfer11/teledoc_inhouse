<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);

        // Create admin user
        $doctor = User::firstOrCreate(
            ['email' => 'john@yopmail.com'],
            [
                'name' => 'John',
                'password' => Hash::make('Test@123'),
                'email_verified_at' => now(),
                'role_id' => $doctorRole->id,
                'created_by' => 0
            ]
        );

        $doctor->assignRole('doctor');
    }
}
