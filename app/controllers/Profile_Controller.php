<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Profile_Controller extends Controller {
	public function __construct() {
		parent::__construct();
		$this->call->model('User_Model');
		$this->call->library(['form_validation', 'upload']);
		$this->call->helper(['url', 'message', 'directory']);
		$this->ensure_authenticated();
	}

	private function ensure_authenticated() {
		if (!$this->session->has_userdata('user_id')) {
			setMessage('danger', 'Please login to continue.');
			redirect('/login');
		}
	}

	public function index() {
		$user = $this->User_Model->find($this->session->userdata('user_id'));
		$this->call->view('profile/index', ['user' => $user]);
	}

	public function update() {
		$this->form_validation
			->name('name')->required()->min_length(2)->max_length(100)
			->name('email')->required()->valid_email();

		if ($this->form_validation->run() == FALSE) {
			setErrors($this->form_validation->get_errors());
			redirect('/profile');
			return;
		}

		$name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

		$current_user_id = $this->session->userdata('user_id');
		$existing = $this->User_Model->find_by_email($email);
		if ($existing && (int)$existing['id'] !== (int)$current_user_id) {
			setErrors(['Email is already in use by another account.']);
			redirect('/profile');
			return;
		}

		$this->User_Model->update_profile($current_user_id, [
			'name' => $name,
			'email' => $email,
		]);

		$this->session->set_userdata([
			'user_name' => $name,
			'user_email' => $email
		]);

		setMessage('success', 'Profile updated.');
		redirect('/profile');
	}

	public function upload_avatar() {
		if (!isset($_FILES['avatar'])) {
			setErrors(['No file uploaded.']);
			redirect('/profile');
			return;
		}

		$uploads_path = ROOT_DIR . PUBLIC_DIR . '/uploads/avatars';
		if (!is_dir_usable($uploads_path)) {
			setErrors(['Upload directory is not writable.']);
			redirect('/profile');
			return;
		}

		$upload = new Upload($_FILES['avatar']);
		$upload->is_image()
			->allowed_extensions(['gif','jpg','jpeg','png'])
			->allowed_mimes(['image/gif','image/jpg','image/jpeg','image/png'])
			->max_size(5)
			->set_dir($uploads_path)
			->encrypt_name();

		if (!$upload->do_upload()) {
			setErrors($upload->get_errors());
			redirect('/profile');
			return;
		}

		$filename = $upload->get_filename();
		$relative = PUBLIC_DIR . '/uploads/avatars/' . $filename;
		$user_id = $this->session->userdata('user_id');

		// Optionally remove old avatar
		$current = $this->User_Model->find($user_id);
		if ($current && !empty($current['avatar'])) {
			$old = ROOT_DIR . $current['avatar'];
			if (is_file($old)) { @unlink($old); }
		}

		$this->User_Model->update_avatar($user_id, $relative);
		$this->session->set_userdata(['user_avatar' => $relative]);
		setMessage('success', 'Avatar updated.');
		redirect('/profile');
	}
}
?>

