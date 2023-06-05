<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Angga',
            'email' => 'angga@email.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
    }
}
