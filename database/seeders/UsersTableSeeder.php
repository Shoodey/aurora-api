<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->has(Channel::factory(2))
            ->has(Channel::factory(1)->isPasswordProtected())
            ->create([
                'name'           => 'John Doe',
                'email'          => 'jdoe@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(10),
            ]);

        User::factory(10)->create();
    }
}
