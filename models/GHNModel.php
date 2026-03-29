<?php
// models/GHNModel.php
require_once __DIR__ . '/../config.php';

class GHNModel
{

    private $api_url = "https://dev-online-gateway.ghn.vn/shiip/public-api";

    private function request($endpoint, $data = [], $method = 'GET', $is_v2 = false)
    {
        $url = $this->api_url . $endpoint;
        $headers = [
            'token: ' . GHN_API_TOKEN, 
            'Content-Type: application/json'
        ];

        if ($is_v2) {
            $headers[] = 'ShopId: ' . GHN_SHOP_ID;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

       
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $error = curl_error($ch); 
        curl_close($ch);

        if ($error) {
            return ['code' => 500, 'message' => 'Lỗi cURL: ' . $error];
        }

        return json_decode($response, true);
    }

    public function getProvinces()
    {
        return $this->request('/master-data/province');
    }

    public function getDistricts($province_id)
    {
       
        return $this->request('/master-data/district', ['province_id' => intval($province_id)], 'POST');
    }

    public function getWards($district_id)
    {
        return $this->request('/master-data/ward', ['district_id' => intval($district_id)], 'POST');
    }

    public function calculateFee($to_district_id, $to_ward_code, $weight = 1000)
    {
        $data = [
            'service_type_id' => 2,
            'from_district_id' => intval(GHN_FROM_DISTRICT_ID),
            'to_district_id' => intval($to_district_id),
            'to_ward_code' => (string) $to_ward_code, 
            'weight' => intval($weight)
        ];
        return $this->request('/v2/shipping-order/fee', $data, 'POST', true);
    }

    public function createOrder($orderData)
    {
        // Endpoint để tạo đơn hàng
        return $this->request('/v2/shipping-order/create', $orderData, 'POST', true);
    }
}