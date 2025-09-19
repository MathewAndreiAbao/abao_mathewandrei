<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class TaskController extends Controller {
    protected $per_page = 6;

    public function __construct()
    {
        parent::__construct();
        if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
        if (!isset($_SESSION['user_id'])) {
            redirect('/auth/login');
        }

        // ensure uploads folder exists
        $uploadDir = APP_DIR . '..' . DIRECTORY_SEPARATOR . 'uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    }

    public function index()
    {
        $this->call->model('TaskModel');
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $search = trim($_GET['q'] ?? '');

        $result = $this->TaskModel->findAllByUser($_SESSION['user_id'], $page, $this->per_page, $search);

        $data = ['tasks' => $result['data'], 'pagination' => $result, 'search' => $search];
        $this->call->view('tasks/dashboard', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $due_date = $_POST['due_date'] ?? null;
            $status = $_POST['status'] ?? 'pending';
            $errors = [];

            if (empty($title)) $errors[] = 'Title is required.';

            $file_path = null;
            if (!empty($_FILES['attachment']['name'])) {
                $upload = $this->handleUpload($_FILES['attachment']);
                if (isset($upload['error'])) {
                    $errors[] = $upload['error'];
                } else {
                    $file_path = $upload['path'];
                }
            }

            if (empty($errors)) {
                $this->call->model('TaskModel');
                $this->TaskModel->createTask([
                    'user_id' => $_SESSION['user_id'],
                    'title' => $title,
                    'description' => $description,
                    'due_date' => $due_date,
                    'status' => $status,
                    'file_path' => $file_path
                ]);

                $_SESSION['flash_success'] = 'Task created.';
                redirect('/tasks');
            }

            $this->call->view('tasks/create', ['errors' => $errors]);
            return;
        }

        $this->call->view('tasks/create');
    }

    public function view($id = null)
    {
        $this->call->model('TaskModel');
        $task = $this->TaskModel->find($id);
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['flash_error'] = 'Task not found.';
            redirect('/tasks');
        }
        $this->call->view('tasks/view', ['task' => $task]);
    }

    public function edit($id = null)
    {
        $this->call->model('TaskModel');
        $task = $this->TaskModel->find($id);
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['flash_error'] = 'Task not found.';
            redirect('/tasks');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $due_date = $_POST['due_date'] ?? null;
            $status = $_POST['status'] ?? 'pending';
            $errors = [];

            if (empty($title)) $errors[] = 'Title is required.';

            $file_path = $task['file_path'];
            if (!empty($_FILES['attachment']['name'])) {
                $upload = $this->handleUpload($_FILES['attachment']);
                if (isset($upload['error'])) {
                    $errors[] = $upload['error'];
                } else {
                    // remove old file
                    if (!empty($task['file_path']) && file_exists(APP_DIR . '..' . DIRECTORY_SEPARATOR . $task['file_path'])) {
                        @unlink(APP_DIR . '..' . DIRECTORY_SEPARATOR . $task['file_path']);
                    }
                    $file_path = $upload['path'];
                }
            }

            if (empty($errors)) {
                $this->TaskModel->updateTask($id, [
                    'title' => $title,
                    'description' => $description,
                    'due_date' => $due_date,
                    'status' => $status,
                    'file_path' => $file_path
                ]);

                $_SESSION['flash_success'] = 'Task updated.';
                redirect('/tasks');
            }

            $this->call->view('tasks/edit', ['task' => $task, 'errors' => $errors]);
            return;
        }

        $this->call->view('tasks/edit', ['task' => $task]);
    }

    public function delete($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/tasks');
        $this->call->model('TaskModel');
        $task = $this->TaskModel->find($id, true);
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['flash_error'] = 'Task not found.';
            redirect('/tasks');
        }

        // permanently delete the task
        $this->TaskModel->delete($id);
        $_SESSION['flash_success'] = 'Task deleted.';
        redirect('/tasks');
    }

    protected function handleUpload($file)
    {
        $allowed = ['application/pdf','image/jpeg','image/png'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if ($file['error'] !== UPLOAD_ERR_OK) return ['error' => 'File upload error.'];
        if ($file['size'] > $maxSize) return ['error' => 'File exceeds maximum size of 5MB.'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowed)) return ['error' => 'Invalid file type. Allowed: PDF, JPG, PNG.'];

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('attach_', true) . '.' . $ext;
        $relPath = 'uploads' . DIRECTORY_SEPARATOR . $filename;
        $dest = APP_DIR . '..' . DIRECTORY_SEPARATOR . $relPath;

        if (!move_uploaded_file($file['tmp_name'], $dest)) return ['error' => 'Unable to move uploaded file.'];

        return ['path' => $relPath];
    }
}
