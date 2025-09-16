<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Profile_Controller extends Controller {
    public function __construct() {
        parent::__construct();
        $this->call->model('User_Model');
        $this->call->library(['form_validation', 'upload']);
        $this->call->helper(['url', 'message', 'directory']);
    }

    public function upload_avatar() {
        if (!$this->session->has_userdata('user_id')) {
            setMessage('danger', 'Please login to continue.');
            redirect('/login');
            return;
        }

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            setErrors(['No file uploaded or upload error.']);
            redirect('/');
            return;
        }

        $uploads_path = ROOT_DIR . PUBLIC_DIR . '/uploads/avatars/';
        if (!is_dir($uploads_path)) {
            mkdir($uploads_path, 0777, true);
        }
        if (!is_writable($uploads_path)) {
            setErrors(['Upload directory is not writable.']);
            redirect('/');
            return;
        }

        $upload = new Upload($_FILES['avatar']);
        $upload->is_image()
            ->allowed_extensions(['gif', 'jpg', 'jpeg', 'png'])
            ->allowed_mimes(['image/gif', 'image/jpg', 'image/jpeg', 'image/png'])
            ->max_size(5)
            ->set_dir($uploads_path)
            ->encrypt_name();

        if (!$upload->do_upload()) {
            setErrors($upload->get_errors());
            redirect('/');
            return;
        }

        $filename = $upload->get_filename();
        $relative = '/uploads/avatars/' . $filename;  // Relative to public dir
        $user_id = $this->session->userdata('user_id');

        // Remove old avatar if exists
        $current = $this->User_Model->find($user_id);
        if ($current && !empty($current['avatar'])) {
            $old_path = ROOT_DIR . PUBLIC_DIR . $current['avatar'];
            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }

        $this->User_Model->update_avatar($user_id, $relative);
        $this->session->set_userdata('user_avatar', $relative);
        setMessage('success', 'Avatar updated.');
        redirect('/');
    }
}
?>
