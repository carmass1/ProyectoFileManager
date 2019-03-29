<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->truncate();
		DB::table('folders')->truncate();
		DB::table('files')->truncate();

        User::create([
			'name' => 'Supaaaa',
			'role' => 'super',
			'password' => bcrypt('123'),
			'email' => 'super',
		]);

		User::create([
			'name' => 'Adminnn',
			'role' => 'admin',
			'password' => bcrypt('123'),
			'email' => 'admin',
		]);

		User::create([
			'name' => 'Clienteeee',
			'role' => 'cliente',
			'password' => bcrypt('123'),
			'email' => 'cliente',
			'ruc' => '123456',
			'flag' => 'Primax',
			'group' => 'Grupo San ignacio',
			'direction' => 'lejotes',
			'contacts' => '[]',
		]);

		User::create([
			'name' => 'Gasocentro SAC',
			'role' => 'cliente',
			'password' => bcrypt('123'),
			'email' => 'gas',
			'ruc' => '123456',
			'flag' => 'Primax',
			'group' => 'Grupo San ignacio',
			'direction' => 'cerca',
			'contacts' => '[]',
		]);

		User::create([
			'name' => 'Las Flores',
			'role' => 'cliente',
			'password' => bcrypt('123'),
			'email' => 'flores',
			'ruc' => '123456',
			'flag' => 'Primax',
			'group' => 'Grupo San ignacio',
			'direction' => 'ventanilla',
			'contacts' => '[]',
		]);
    }
}
