<?php
// File: app/controllers/Auth_Controller.php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth_Controller extends Controller {
    public function __construct() {
        parent::__construct();
        $this->call->model('User_Model');
        $this->call->library('form_validation');
        $this->call->helper(['url', 'security', 'message']);
    }

    private function redirect_if_authenticated() {
        if ($this->session->has_userdata('user_id')) {
            redirect('/');
        }
    }

    public function login() {
        try {
            $this->redirect_if_authenticated();
            $this->call->view('auth/login');
        } catch (Exception $e) {
            error_log('Login Error: ' . $e->getMessage());
            setErrors(['An error occurred. Please try again.']);
            $this->call->view('auth/login');
        }
    }

    public function register() {
        try {
            $this->redirect_if_authenticated();
            $this->call->view('auth/register');
        } catch (Exception $e) {
            error_log('Register Error: ' . $e->getMessage());
            setErrors(['An error occurred. Please try again.']);
            $this->call->view('auth/register');
        }
    }

    public function do_register() {
        try {
            $this->form_validation
                ->name('name')->required()->min_length(2)->max_length(100)
                ->name('email')->required()->valid_email()
                ->name('password')->required()->min_length(6)
                ->name('password_confirm')->required()->matches('password');

            if ($this->form_validation->run() == FALSE) {
                setErrors($this->form_validation->get_errors());
                redirect('/register');
                return;
            }

            $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if ($this->User_Model->find_by_email($email)) {
                setErrors(['Email is already registered.']);
                redirect('/register');
                return;
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);
            $this->User_Model->create_user($name, $email, $hash);

            setMessage('success', 'Registration successful. Please login.');
            redirect('/login');
        } catch (Exception $e) {
            error_log('Do Register Error: ' . $e->getMessage());
            setErrors(['Registration failed. Please try again.']);
            redirect('/register');
        }
    }

    public function do_login() {
        try {
            $this->form_validation
                ->name('email')->required()->valid_email()
                ->name('password')->required();

            if ($this->form_validation->run() == FALSE) {
                setErrors($this->form_validation->get_errors());
                redirect('/login');
                return;
            }

            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $user = $this->User_Model->find_by_email($email);

            if (!$user || !password_verify($password, $user['password_hash'])) {
                setErrors(['Invalid email or password.']);
                redirect('/login');
                return;
            }

            $this->session->set_userdata([
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_email' => $user['email'],
                'user_avatar' => $user['avatar'] ?? null
            ]);
            redirect('/');
        } catch (Exception $e) {
            error_log('Do Login Error: ' . $e->getMessage());
            setErrors(['Login failed. Please try again.']);
            redirect('/login');
        }
    }

    public function logout() {
        try {
            $this->session->sess_destroy();
            setMessage('success', 'Logged out successfully.');
            redirect('/login');
        } catch (Exception $e) {
            error_log('Logout Error: ' . $e->getMessage());
            redirect('/login');
        }
    }
}
?>
