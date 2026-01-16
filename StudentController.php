<?php
require_once __DIR__ . '/../models/StudentModel.php';

class StudentController {
    private $model;

    public function __construct() {
        $this->model = new StudentModel();
    }

    /**
     * Validate dữ liệu không rỗng
     * @param array $data Dữ liệu cần validate
     * @return array ['valid' => bool, 'message' => string]
     */
    private function validateData($data) {
        // Lọc bỏ id vì có thể null
        $dataToValidate = array_filter($data, function($key) {
            return $key !== 'id';
        }, ARRAY_FILTER_USE_KEY);

        // Kiểm tra có dữ liệu không
        if (empty($dataToValidate)) {
            return ['valid' => false, 'message' => 'Vui lòng nhập đầy đủ dữ liệu'];
        }

        // Kiểm tra các trường không rỗng
        foreach ($dataToValidate as $key => $value) {
            if (is_string($value) && trim($value) === '') {
                return ['valid' => false, 'message' => 'Không được để trống các trường dữ liệu'];
            }
        }

        return ['valid' => true, 'message' => ''];
    }

    public function index() {
        require __DIR__ . '/../views/layout.php';
    }

    public function api() {
        header('Content-Type: application/json');
        $action = $_GET['action'] ?? '';

        try {
            switch ($action) {
                case 'list':
                    echo json_encode(['success'=>true,'data'=>$this->model->all()]);
                    break;

                case 'create':
                    $validation = $this->validateData($_POST);
                    if (!$validation['valid']) {
                        throw new Exception($validation['message']);
                    }
                    $this->model->create($_POST);
                    echo json_encode(['success'=>true,'message'=>'Thêm thành công']);
                    break;

                case 'update':
                    $validation = $this->validateData($_POST);
                    if (!$validation['valid']) {
                        throw new Exception($validation['message']);
                    }
                    $this->model->update($_POST['id'], $_POST);
                    echo json_encode(['success'=>true,'message'=>'Cập nhật thành công']);
                    break;

                case 'delete':
                    $this->model->delete($_POST['id']);
                    echo json_encode(['success'=>true,'message'=>'Xóa thành công']);
                    break;
            }
        } catch (Exception $e) {
            echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
        }
    }
}
