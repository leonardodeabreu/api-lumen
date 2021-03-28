<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PopulateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $user = DB::table('users');
        if ($user->count() <= 0) {
            $user->insert([
                'name'     => 'Admin',
                'email'    => 'teste@teste.com',
                'phone'    => '44999992222',
                'age'      => 25,
                'active'   => true,
                'password' => Hash::make('teste@teste.com'),
            ]);
        }
    }
}
