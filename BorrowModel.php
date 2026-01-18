<?php
require_once 'core/Database.php';

class BorrowModel {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        $sql = "SELECT b.id, m.full_name, bk.title,
                       b.borrow_date, b.due_date, b.return_date, b.status
                FROM borrows b
                JOIN members m ON b.member_id = m.id
                JOIN books bk ON b.book_id = bk.id
                ORDER BY b.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create($d) {
        // trừ sách
        $this->db->prepare(
            "UPDATE books SET quantity = quantity - 1 WHERE id=? AND quantity>0"
        )->execute([$d['book_id']]);

        $sql = "INSERT INTO borrows(member_id,book_id,borrow_date,due_date)
                VALUES(:member_id,:book_id,:borrow_date,:due_date)";
        return $this->db->prepare($sql)->execute($d);
    }

    public function returnBook($id) {
        // cộng sách lại
        $sql = "UPDATE books bk
                JOIN borrows br ON bk.id = br.book_id
                SET bk.quantity = bk.quantity + 1,
                    br.status='RETURNED',
                    br.return_date = CURDATE()
                WHERE br.id = ?";
        return $this->db->prepare($sql)->execute([$id]);
    }
}
