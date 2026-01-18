<?php
require_once 'models/MemberModel.php';

class MemberController {
    private $model;

    public function __construct() {
        $this->model = new MemberModel();
    }

    // Trang quản lý độc giả
    public function index() {
        require 'views/layout/header.php';
        require 'views/members/index.php';
        require 'views/layout/footer.php';
    }

    // API Ajax
    public function api() {
        header('Content-Type: application/json; charset=utf-8');
        $action = $_GET['action'] ?? '';

        try {

            /* ===== LIST ===== */
            if ($action === 'list') {
                echo json_encode([
                    'success' => true,
                    'data' => $this->model->all()
                ]);
                return;
            }

            /* ===== CREATE ===== */
            if ($action === 'create') {

                $errors = [];

                $member_code = trim($_POST['member_code'] ?? '');
                $full_name   = trim($_POST['full_name'] ?? '');
                $email       = trim($_POST['email'] ?? '');
                $phone       = trim($_POST['phone'] ?? '');

                if ($member_code === '') {
                    $errors['member_code'] = 'Mã độc giả không được trống';
                }
                if ($full_name === '') {
                    $errors['full_name'] = 'Họ tên không được trống';
                }
                if ($email === '') {
                    $errors['email'] = 'Email không được trống';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Email không hợp lệ';
                }

                if (!empty($errors)) {
                    echo json_encode([
                        'success' => false,
                        'errors' => $errors
                    ]);
                    return;
                }

                $this->model->create([
                    'member_code' => $member_code,
                    'full_name'   => $full_name,
                    'email'       => $email,
                    'phone'       => $phone
                ]);

                echo json_encode([
                    'success' => true,
                    'message' => 'Thêm độc giả thành công'
                ]);
                return;
            }

            /* ===== UPDATE ===== */
            if ($action === 'update') {

                $id = (int)($_POST['id'] ?? 0);
                if ($id <= 0) throw new Exception('ID không hợp lệ');

                $this->model->update($id, [
                    'member_code' => $_POST['member_code'],
                    'full_name'   => $_POST['full_name'],
                    'email'       => $_POST['email'],
                    'phone'       => $_POST['phone']
                ]);

                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật thành công'
                ]);
                return;
            }

            /* ===== DELETE ===== */
            if ($action === 'delete') {

                $id = (int)($_POST['id'] ?? 0);
                if ($id <= 0) throw new Exception('ID không hợp lệ');

                $this->model->delete($id);

                echo json_encode([
                    'success' => true,
                    'message' => 'Xóa thành công'
                ]);
                return;
            }

            throw new Exception('Action không tồn tại');

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
