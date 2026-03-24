<?php
// controllers/GHNController.php
require_once __DIR__ . '/../models/GHNModel.php';

class GHNController
{
    private $model;

    public function __construct()
    {
        $this->model = new GHNModel();
    }

    public function get_provinces()
    {
        header('Content-Type: application/json');
        $response = $this->model->getProvinces();
        if ($response === null || !isset($response['code']) || $response['code'] != 200) {
            echo json_encode(['code' => 500, 'message' => 'Không thể lấy danh sách Tỉnh/Thành từ GHN.', 'ghn_response' => $response]);
        } else {
            echo json_encode($response);
        }
        exit;
    }

    public function get_districts()
    {
        header('Content-Type: application/json');
        $province_id = isset($_GET['province_id']) ? intval($_GET['province_id']) : 0;
        if (!$province_id) {
            echo json_encode(['code' => 400, 'message' => 'Thiếu province_id']);
            exit;
        }
        $response = $this->model->getDistricts($province_id);
        if ($response === null || !isset($response['code']) || $response['code'] != 200) {
            echo json_encode(['code' => 500, 'message' => 'Không thể lấy danh sách Quận/Huyện từ GHN.', 'ghn_response' => $response]);
        } else {
            echo json_encode($response);
        }
        exit;
    }

    public function get_wards()
    {
        header('Content-Type: application/json');
        $district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;
        if (!$district_id) {
            echo json_encode(['code' => 400, 'message' => 'Thiếu district_id']);
            exit;
        }
        $response = $this->model->getWards($district_id);
        if ($response === null || !isset($response['code']) || $response['code'] != 200) {
            echo json_encode(['code' => 500, 'message' => 'Không thể lấy danh sách Phường/Xã từ GHN.', 'ghn_response' => $response]);
        } else {
            echo json_encode($response);
        }
        exit;
    }

    public function calculate_fee()
    {
        header('Content-Type: application/json');
        $to_district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;
        $to_ward_code = isset($_GET['ward_code']) ? $_GET['ward_code'] : '';
        $weight = isset($_GET['weight']) ? intval($_GET['weight']) : 1000; // Mặc định 1kg

        if ($to_district_id && $to_ward_code) {
            $res = $this->model->calculateFee($to_district_id, $to_ward_code, $weight);
            echo json_encode($res);
        } else {
            echo json_encode(['code' => 400, 'message' => 'Thiếu thông tin địa chỉ']);
        }
        exit;
    }
}