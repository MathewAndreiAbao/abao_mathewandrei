<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model {
    protected $table = 'users';
    protected $primary_key = 'id';
    protected $fillable = ['username', 'email', 'password_hash', 'created_at'];

    public function __construct()
    {
        parent::__construct();
    }

    public function findByEmail($email)
    {
        return $this->db->table($this->table)->where('email', $email)->get();
    }

    public function createUser($data)
    {
        $data = $this->fillable_attributes($data);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }
}
