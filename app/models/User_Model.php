<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_Model extends Model {
	protected $table = 'users';
	protected $primary_key = 'id';

	protected $fillable = [
		'name',
		'email',
		'password_hash',
		'avatar',
		'created_at',
		'updated_at'
	];

	public function __construct()
	{
		parent::__construct();
		$this->ensure_table();
	}

	private function ensure_table()
	{
		$sql = "CREATE TABLE IF NOT EXISTS `users` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(100) NOT NULL,
			`email` VARCHAR(191) NOT NULL,
			`password_hash` VARCHAR(255) NOT NULL,
			`avatar` VARCHAR(255) DEFAULT NULL,
			`created_at` DATETIME NOT NULL,
			`updated_at` DATETIME NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `uniq_email` (`email`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		try {
			$this->db->raw($sql);
		} catch (Exception $e) {
			// Silent fail to avoid fatal on restricted environments
		}
	}

	public function find_by_email($email)
	{
		return $this->db->table($this->table)->where('email', $email)->limit(1)->get();
	}

	public function create_user($name, $email, $password_hash)
	{
		$now = date('Y-m-d H:i:s');
		return $this->db->table($this->table)->insert([
			'name' => $name,
			'email' => $email,
			'password_hash' => $password_hash,
			'created_at' => $now,
			'updated_at' => $now
		]);
	}

	public function update_profile($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->table($this->table)->where('id', $id)->update($data);
	}

	public function update_avatar($id, $avatar_path)
	{
		return $this->update_profile($id, ['avatar' => $avatar_path]);
	}
}
?>

