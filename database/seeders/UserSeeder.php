<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email','developer@test.com')->first();

        if(!$user) {
            DB::table('users')->insert([
                'name' => 'developer',
                'email' => 'developer@test.com',
                'password' => bcrypt('Test@Dev123#'),
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);
        }
    }
}
