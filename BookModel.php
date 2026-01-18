<?php
require_once 'core/Database.php';

class BookModel {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        return $this->db->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();
    }

    public function create($d) {
        $sql = "INSERT INTO books(isbn,title,author,category,quantity)
                VALUES(:isbn,:title,:author,:category,:quantity)";
        return $this->db->prepare($sql)->execute($d);
    }

    public function update($id,$d) {
        $d['id']=$id;
        $sql="UPDATE books SET isbn=:isbn,title=:title,author=:author,
              category=:category,quantity=:quantity WHERE id=:id";
        return $this->db->prepare($sql)->execute($d);
    }

    public function delete($id) {
        return $this->db->prepare("DELETE FROM books WHERE id=?")->execute([$id]);
    }
}
