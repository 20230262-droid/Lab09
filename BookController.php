<?php
require_once 'models/BookModel.php';

class BookController {
    private $model;
    public function __construct() {
        $this->model = new BookModel();
    }

    public function index() {
        require 'views/layout/header.php';
        require 'views/books/index.php';
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
                $data = [];
                $data['isbn'] = trim($p['isbn'] ?? '');
                if ($data['isbn'] === '') $data['isbn'] = uniqid('isbn_');
                $data['title'] = trim($p['title'] ?? '');
                $data['author'] = trim($p['author'] ?? '');
                $data['category'] = trim($p['category'] ?? '');
                $data['quantity'] = is_numeric($p['quantity'] ?? null) ? (int)$p['quantity'] : 1;

                if ($data['title'] === '' || $data['author'] === '') {
                    echo json_encode(['success'=>false,'message'=>'Title and author are required']);
                    return;
                }

                $ok = $this->model->create($data);
                echo json_encode(['success'=>true,'inserted'=>$ok]);
            } catch (Exception $ex) {
                echo json_encode(['success'=>false,'message'=>$ex->getMessage()]);
            }
            return;
        }

        if ($action === 'update') {
            $this->model->update($_POST['id'],$_POST);
            echo json_encode(['success'=>true]);
            return;
        }

        if ($action === 'delete') {
            $this->model->delete($_POST['id']);
            echo json_encode(['success'=>true]);
        }
    }
}
