<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => config('auth.admin.name'),
            'email' => config('auth.admin.email'),
            'password' => bcrypt(config('auth.admin.password')),
        ]);
    }
}
