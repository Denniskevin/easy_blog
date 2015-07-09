<?php

class UserTableSeeder extends Seeder {
	public function run()
	{
		User::create([
			'email'    => 'admin@fanahub.org',
			'password' => Hash::make('123456'),
			'nickname' => 'admin',
			'is_admin' => 1,
		]);

		User::create([
			'email'    => 'user@fanshub.org',
			'password' => Hash::make('123456'),
			'nickname' => 'snow',
			'is_admin' => 0,
		]);

        User::create([
            'email'    => 'blog@fanshub.org',
            'password' => Hash::make('123456'),
            'nickname' => 'snow',
            'is_admin' => 0,
        ]);
	}
}