<?php

namespace Database\Seeders;

use App\Http\Actions\AddMenuToNewUser;
use App\Models\User;
use Bouncer;
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
        $users = User::factory(1)->create(
            [
                'first_name' => 'Humam',
                'last_name' => 'Albitar',
                'email' => 'Humam@test.com',
                'email_verified_at' => null,
                'password' => bcrypt('12345678')
            ]
        );
        AddMenuToNewUser::execute($users->first());
        Bouncer::assign('admin')->to($users->first());
    }
}
