<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@user.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('test'),
            'remember_token' => \Str::random(10),
            'type' => User::TYPE_ADMIN,
        ]);

        User::create([
            'name' => 'Courier',
            'email' => 'courier@user.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('test'),
            'remember_token' => \Str::random(10),
            'type' => User::TYPE_COURIER,
        ]);

        User::create([
            'name' => 'Guest',
            'email' => 'guest@user.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('test'),
            'remember_token' => \Str::random(10),
            'type' => User::TYPE_GUEST,
        ]);
    }
}
