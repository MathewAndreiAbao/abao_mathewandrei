<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class TaskModel extends Model {
    protected $table = 'tasks';
    protected $primary_key = 'id';
    protected $fillable = ['user_id','title','description','due_date','status','file_path','created_at','updated_at'];

    public function __construct()
    {
        parent::__construct();
    }

    public function createTask($data)
    {
        $data = $this->fillable_attributes($data);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    public function findAllByUser($user_id, $page = 1, $per_page = 10, $search = '')
    {
        $page = max(1, (int)$page);
        $per_page = max(1, (int)$per_page);
        $offset = ($page - 1) * $per_page;

        $where = 'WHERE user_id = ?';
        $params = [$user_id];

        if (!empty($search)) {
            $like = '%' . $search . '%';
            $where .= ' AND (title LIKE ? OR description LIKE ? )';
            $params[] = $like;
            $params[] = $like;
        }

        // get total using COUNT
        $countSql = "SELECT COUNT(*) as c FROM {$this->table} {$where}";
        $countStmt = $this->db->raw($countSql, $params);
        $total = (int) ($countStmt->fetch(PDO::FETCH_ASSOC)['c'] ?? 0);

        // fetch page results - embed limit/offset as integers
        $sql = "SELECT * FROM {$this->table} {$where} ORDER BY COALESCE(due_date, created_at) ASC LIMIT " . (int)$offset . "," . (int)$per_page;
        $stmt = $this->db->raw($sql, $params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $per_page,
            'current_page' => $page,
            'last_page' => $total ? ceil($total / $per_page) : 1
        ];
    }

    public function updateTask($id, $data)
    {
        $data = $this->fillable_attributes($data);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }
    // permanent delete can be handled via Model::delete($id)
}
