<?php
require_once 'models/BorrowModel.php';

class BorrowController {
    private $model;
    public function __construct() {
        $this->model = new BorrowModel();
    }

    public function index() {
        require 'views/layout/header.php';
        require 'views/borrows/index.php';
        require 'views/layout/footer.php';
    }

    public function api() {
        header('Content-Type: application/json');
        $action = $_GET['action'] ?? '';

        if ($action === 'list') {
            echo json_encode(['success'=>true,'data'=>$this->model->all()]);
            return;
        }

        if ($action === 'create') {
            try {
                $p = $_POST;
                $member_id = isset($p['member_id']) ? (int)$p['member_id'] : 0;
                $book_id = isset($p['book_id']) ? (int)$p['book_id'] : 0;
                $borrow_date = $p['borrow_date'] ?? '';
                $due_date = $p['due_date'] ?? '';

                if ($member_id <= 0 || $book_id <= 0 || $borrow_date === '' || $due_date === '') {
                    echo json_encode(['success'=>false,'message'=>'Thiếu thông tin mượn']);
                    return;
                }

                $data = [
                    'member_id' => $member_id,
                    'book_id' => $book_id,
                    'borrow_date' => $borrow_date,
                    'due_date' => $due_date
                ];

                $ok = $this->model->create($data);
                echo json_encode(['success'=>true,'message'=>'Mượn thành công','ok'=>$ok]);
            } catch (Exception $ex) {
                echo json_encode(['success'=>false,'message'=>$ex->getMessage()]);
            }
            return;
        }

        if ($action === 'return') {
            $this->model->returnBook($_POST['id']);
            echo json_encode(['success'=>true,'message'=>'Đã trả sách']);
        }
    }
}
