<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Loan_Model extends Model {
    protected $table = 'loans';
    protected $primary_key = 'id';

    protected $fillable = [
        'borrower_name',
        'loan_amount',
        'interest_rate',
        'created_at',
        'updated_at'
    ];

    public function getAll() {
        return $this->db->table($this->table)->get_all();
    }

    public function createLoan($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateLoan($id, $data) {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function deleteLoan($id) {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}
?>