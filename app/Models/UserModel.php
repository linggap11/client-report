<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['fullname', 'company', 'email', 'address', 'username', 'password', 'photo', 'role', 'under_comp'];
    protected $db = "";

    public function getAllUser()
    {
        $this->db = \Config\Database::connect();
        $query = $this->db->query("SELECT * FROM users WHERE role <> 'superadmin' ORDER BY fullname ASC ");
        return $query;
    }

    public function logActivity($user, $page, $ip = null) {
        $this->db = \Config\Database::connect();
        $this->db->query("INSERT INTO log_pages(user_id, page) VALUES('$user', '$page')");
        if (!is_null($ip)) {
            $this->db->query("INSERT INTO log_logins(user_id, ip_address) VALUES('$user', '$ip')");
        }
    }
}
