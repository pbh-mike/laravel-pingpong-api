<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

	$users = array(
		'section' => 'Users',
		'endpoints' => array(
			array(
				'name' => 'Login',
				'url' => '/api/auth/login',
				'payload' => '{
					email: [string],
					password: [string]
				}',
				'returns' => '{
					access_token: [jwt]
					user: [the logged in user object]
				}',
				'explain' => 'Logs the user in and generates a json web token'
			),
			array(
				'name' => 'Update User',
				'url' => '/api/auth/update',
				'payload' => '',
				'returns' => '',
				'explain' => ''
			),
			array(
				'name' => 'Register',
				'url' => '/api/auth/register',
				'payload' => '',
				'returns' => '',
				'explain' => ''
			),
			array(
				'name' => 'Get logged in user',
				'url' => '/api/auth/me',
				'payload' => '',
				'returns' => '',
				'explain' => ''
			),
			array(
				'name' => 'Logout',
				'url' => '/api/auth/logout',
				'payload' => '',
				'returns' => '',
				'explain' => ''
			)
		)
	);

	$events = array(
		'section' => 'Events',
		'endpoints' => array(
			array(
				'name' => 'Get events',
				'url' => '/api/events',
				'payload' => '',
				'returns' => '',
				'explain' => ''
			),
			array(
				'name' => 'Get single event',
				'url' => '/api/events/{id}',
				'payload' => '',
				'returns' => '',
				'explain' => ''
			)
		)
	);

	$docs = array($users, $events);

    return view('documentation', ['docs' => $docs]);
});
