<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SeedLocalData extends Seeder
{

    /**
     * Run the database seeds.
     * @return void
     */
    public function run ()
    {
        if (!app()->environment('local')) {
            return;
        }

        DB::table('users')
          ->insert([
              'nickname'      => 'Ozair Patel',
              'email'         => 'ozairpatel2@gmail.com',
              'joined_at'     => "",
              'discord_id'    => '123456789',
              'avatar'        => 'https://cdn.discordapp.com/avatars/123456789/123456789.png',
              'roles'         => '[]',
              'access_token'  => '123456789',
              'refresh_token' => '123456789',
          ]);
    }
}
