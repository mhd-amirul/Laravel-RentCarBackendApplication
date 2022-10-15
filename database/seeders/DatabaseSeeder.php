<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\otpCode;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create(
            [
                "first_name" => "Muhammad",
                "last_name" => "Amirul",
                "email" => "lohsu86@gmail.com",
                "no_hp" => "082300000000",
                "password" => Hash::make('11111'),
            ]
        );

        otpCode::create(
            [
                "email" => "lohsu86@gmail.com",
                "otp" => 5171
            ]
        );
    }
}
