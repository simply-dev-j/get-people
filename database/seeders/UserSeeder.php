<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $env = env('APP_ENV', 'local');

        if($env == 'local') {
            if (User::where('name', 'root')->first() == null) {
                $user = User::create([
                    'name' => 'root',
                    'username' => 'root',
                    'is_admin' => true,
                    'security_code' => '111',
                    'active' => true,
                    'password' => Hash::make('123456'),
                    'withdrawn' => 5000000,
                    'money_added' => 5000000
                ]);

                $user->entry()->create([
                    'stage' => 1
                ]);
            }
        } else {
            if (User::where('name', 'root')->first() == null) {
                $user = User::create([
                    'name' => 'root',
                    'username' => 'root',
                    'is_admin' => true,
                    'security_code' => '111',
                    'active' => true,
                    'password' => Hash::make('123456'),
                    'withdrawn' => 5000000,
                    'money_added' => 5000000
                ]);

                $user->entry()->create([
                    'stage' => 1
                ]);
            }
        }
    }
}
