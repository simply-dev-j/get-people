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
                    'name' => 'cjcth131419',
                    'username' => '富强',
                    'is_admin' => true,
                    'security_code' => '111',
                    'active' => true,
                    'password' => Hash::make('888777'),
                    'withdrawn' => 10000000,
                    'money_added' => 10000000,
                    'phone' => '13998281738',
                    'id_number' => '2139619665678777'
                ]);

                $user->entry()->create([
                    'stage' => 1
                ]);
            }
        } else {
            if (User::where('name', 'root')->first() == null) {
                $user = User::create([
                    'name' => 'cjcth131419',
                    'username' => '富强',
                    'is_admin' => true,
                    'security_code' => '111',
                    'active' => true,
                    'password' => Hash::make('888777'),
                    'withdrawn' => 10000000,
                    'money_added' => 10000000,
                    'phone' => '13998281738',
                    'id_number' => '2139619665678777'
                ]);

                $user->entry()->create([
                    'stage' => 1
                ]);
            }
        }
    }
}
