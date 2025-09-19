<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Config Files
| -------------------------------------------------------------------
| This file is for setting-up default settings.
|
*/

$config['VERSION']                 = '4.2.2';
$config['ENVIRONMENT']             = 'development';
$config['base_url']                = '';
$config['index_page']              = 'index.php';
$config['log_threshold']           = 0;
$config['log_dir']                 = 'runtime/logs/';
$config['composer_autoload']       = FALSE;
$config['permitted_uri_chars']     = 'a-z 0-9~%.:_-';
$config['charset']                 = 'UTF-8';
$config['error_view_path']         = '';
$config['404_override']            = '';
$config['language']                = 'en-US';
$config['sess_driver']             = 'file';
$config['sess_cookie_name']        = 'LLSession';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = '/tmp';
$config['sess_match_ip']           = FALSE;
$config['sess_match_fingerprint']  = TRUE;
$config['sess_time_to_update']     = 300;
$config['sess_regenerate_destroy'] = TRUE;
$config['sess_expire_on_close']    = FALSE;
$config['cookie_prefix']           = '';
$config['cookie_domain']           = '';
$config['cookie_path']             = '/';
$config['cookie_secure']           = FALSE;
$config['cookie_expiration']       = 86400;
$config['cookie_httponly']         = FALSE;
$config['cookie_samesite']         = 'Lax';
$config['cache_dir']               = 'runtime/cache/';
$config['cache_default_expires']   = 0;
$config['encryption_key']          = '';
$config['soft_delete']             = FALSE;
$config['soft_delete_column']      = 'deleted_at';
$config['csrf_protection']         = FALSE;
$config['csrf_exclude_uris']       = array();
$config['csrf_token_name']         = 'csrf_test_name';
$config['csrf_cookie_name']        = 'csrf_cookie_name';
$config['csrf_expire']             = 7200;
$config['csrf_regenerate']         = FALSE;
?>
