<?php

class UserTableSeeder extends Seeder {
	public function run()
	{
		User::create([
			'email'    => 'admin@xchub.cn',
			'password' => Hash::make('123456'),
			'nickname' => 'admin',
			'is_admin' => 1,
		]);
	}
}