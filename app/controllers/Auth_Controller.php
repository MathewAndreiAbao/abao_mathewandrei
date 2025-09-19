<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {
    public function __construct()
    {
        parent::__construct();
        if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors = [];

            if (empty($username) || empty($email) || empty($password)) {
                $errors[] = 'All fields are required.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email.';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            }

            $this->call->model('UserModel');
            if ($this->UserModel->findByEmail($email)) {
                $errors[] = 'Email already registered.';
            }

            if (empty($errors)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $userId = $this->UserModel->createUser([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => $password_hash
                ]);

                $_SESSION['flash_success'] = 'Account created. Please log in.';
                redirect('/auth/login');
            }

            // show form with errors
            $data['errors'] = $errors;
            $this->call->view('auth/signup', $data);
            return;
        }

        $this->call->view('auth/signup');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors = [];

            if (empty($email) || empty($password)) {
                $errors[] = 'Email and password are required.';
            }

            $this->call->model('UserModel');
            $user = $this->UserModel->findByEmail($email);
            if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors[] = 'Invalid credentials.';
            }

            if (empty($errors)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['flash_success'] = 'Logged in successfully.';
                redirect('/tasks');
            }

            $data['errors'] = $errors;
            $this->call->view('auth/login', $data);
            return;
        }

        $this->call->view('auth/login');
    }

    public function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
        session_unset();
        session_destroy();
        redirect('/auth/login');
    }
}
