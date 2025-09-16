<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// Auth routes
$router->get('/', 'Auth_Controller::login');
$router->get('/login', 'Auth_Controller::login');
$router->post('/login', 'Auth_Controller::do_login');
$router->get('/register', 'Auth_Controller::register');
$router->post('/register', 'Auth_Controller::do_register');
$router->post('/logout', 'Auth_Controller::logout');

// Profile routes (protected in controller)
$router->get('/profile', 'Profile_Controller::index');
$router->post('/profile/update', 'Profile_Controller::update');
$router->post('/profile/avatar', 'Profile_Controller::upload_avatar');
?>