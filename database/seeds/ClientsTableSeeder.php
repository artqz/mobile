<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::insert('insert into oauth_clients (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked) values (?, ?, ?, ?, ?, ?, ?, ?)',
            [1, null, 'Laravel', '68PBboAl9SXvxmXF0BeKvmWIu4yShMFoP5e4H32B', 'http://localhost', 1, 0, 0]
        );
        \Illuminate\Support\Facades\DB::insert('insert into oauth_clients (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked) values (?, ?, ?, ?, ?, ?, ?, ?)',
            [2, null, 'React client', 'YuMGy00bQjOewsIS2A9XNnvkkReoLNTpHWipAn3a', 'http://localhost', 0, 1, 0]
        );
    }
}
