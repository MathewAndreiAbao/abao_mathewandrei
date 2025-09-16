<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

if (!function_exists('setMessage')) {
    function setMessage($key, $message)
    {
        $LAVA =& lava_instance();
        $LAVA->session->set_flashdata([
            'alert'   => $key,
            'message' => $message
        ]);
    }
}

if (!function_exists('getMessage')) {
    function getMessage()
    {
        $LAVA =& lava_instance();
        $alert   = $LAVA->session->flashdata('alert');
        $message = $LAVA->session->flashdata('message');

        if ($alert && $message) {
            echo '<div class="alert alert-' . htmlspecialchars($alert) . ' alert-dismissible fade show" role="alert">'
                 . htmlspecialchars($message) .
                 '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
    }
}

    if (!function_exists('setErrors')) {
    function setErrors($errors)
    {
        if (empty($errors)) return;

        $LAVA =& lava_instance();
        $LAVA->session->set_flashdata('errors', $errors);
    }
}

if (!function_exists('getErrors')) {
    function getErrors()
    {
        $LAVA =& lava_instance();
        $errors = $LAVA->session->flashdata('errors');

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    ' . htmlspecialchars($error) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
    }
}