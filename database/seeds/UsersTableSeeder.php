<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'role_id' => '1',
        	'name' => 'Admin Roy',
        	'username' => 'admin',
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('admin123456'),
        	 
        ]);
        DB::table('users')->insert([
        	'role_id' => '2',
        	'name' => 'Author Roy',
        	'username' => 'author',
        	'email' => 'author@gmail.com',
        	'password' => bcrypt('author123456'),
        	 
        ]);
    }
}
