<?php
require_once 'core/Database.php';

class MemberModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        return $this->db
            ->query("SELECT * FROM members ORDER BY id DESC")
            ->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO members(member_code, full_name, email, phone)
                VALUES(:member_code, :full_name, :email, :phone)";
        return $this->db->prepare($sql)->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $sql = "UPDATE members 
                SET member_code=:member_code,
                    full_name=:full_name,
                    email=:email,
                    phone=:phone
                WHERE id=:id";
        return $this->db->prepare($sql)->execute($data);
    }

    public function delete($id) {
        return $this->db
            ->prepare("DELETE FROM members WHERE id=?")
            ->execute([$id]);
    }
}
