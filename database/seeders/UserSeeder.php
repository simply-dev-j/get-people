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
            if (User::where('email', 'quan.dev@outlook.com')->first() == null) {
                $user = User::create([
                    'email' => 'quan.dev@outlook.com',
                    'name' => '一诺',
                    'password' => Hash::make('quan.dev@outlook.com')
                ]);

                $user->entry()->create([
                    'stage' => 1
                ]);
            }
        } else {
            if (User::where('email', 'admin@mail.com')->first() == null) {
                $user = User::create([
                    'email' => 'admin@mail.com',
                    'name' => '一诺',
                    'password' => Hash::make('admin@mail.com')
                ]);

                $user->entry()->create([
                    'stage' => 1
                ]);
            }
        }
    }
}
