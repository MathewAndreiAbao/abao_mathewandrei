<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// Auth routes
$router->get('/', 'Loan_Controller::read');
$router->get('/login', 'Auth_Controller::login');
$router->post('/login', 'Auth_Controller::do_login');
$router->get('/register', 'Auth_Controller::register');
$router->post('/register', 'Auth_Controller::do_register');
$router->post('/logout', 'Auth_Controller::logout');

// Profile routes (protected in controller)
$router->get('/profile', 'Profile_Controller::index');
$router->post('/profile/update', 'Profile_Controller::update');
$router->post('/profile/avatar', 'Profile_Controller::upload_avatar');

// Loan routes
$router->get('/loans', 'Loan_Controller::read');
$router->post('/create-loan', 'Loan_Controller::createLoan');
$router->post('/update-loan/{id}', 'Loan_Controller::updateLoan');
$router->post('/delete-loan/{id}', 'Loan_Controller::deleteLoan');
?>