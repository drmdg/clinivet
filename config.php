<?php

return [
	'email' => [
		'host' => '	smtp.mailtrap.io',
		'port' => 465,
		'username' => '512bf67bbc891e',
		'password' => 'e9591bd8a9c5cd',
	],
	'login' => [
		'admin' => [
			'loggedIn' => 'admin_login',
			'redirect' => '/login',
			'idLoggedIn' => 'id_admin',
		],
		'user' => [
			'loggedIn' => 'user_login',
			'redirect' => '/',
			'idLoggedIn' => 'id_user',
		],
	],
];
