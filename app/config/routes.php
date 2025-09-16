<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$router->get('/', 'Loan_Controller::read');
$router->post('/create-loan', 'Loan_Controller::createLoan');
$router->post('/update-loan/{id}', 'Loan_Controller::updateLoan');
$router->post('/delete-loan/{id}', 'Loan_Controller::deleteLoan');
?>