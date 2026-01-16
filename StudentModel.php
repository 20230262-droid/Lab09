<?php
require_once __DIR__ . '/../core/Database.php';

class StudentModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function all() {
        return $this->pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM students WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO students (code, full_name, email, dob) VALUES (?,?,?,?)"
        );
        return $stmt->execute([
            $data['code'],
            $data['full_name'],
            $data['email'],
            $data['dob'] ?: null
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE students SET code=?, full_name=?, email=?, dob=? WHERE id=?"
        );
        return $stmt->execute([
            $data['code'],
            $data['full_name'],
            $data['email'],
            $data['dob'] ?: null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM students WHERE id=?");
        return $stmt->execute([$id]);
    }
}
