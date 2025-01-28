<?php

namespace Database\Seeders;

use App\Models\User;
use Bouncer;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(1)->create(
            [
                'first_name' => 'Mert',
                'last_name' => 'TAHTALI',
                'email' => 'mert.tahtali@zirvemotomotiv.com',
                'email_verified_at' => null,
                'password' => bcrypt('123123'),
            ]
        );

        Bouncer::assign('admin')->to($users->first());

    }
}
