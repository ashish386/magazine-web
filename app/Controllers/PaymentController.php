<?php

namespace App\Controllers;


class PaymentController extends BaseController {

    public function __construct()
    {
        header("Access-Control-Allow-Origin: * "); 
        header("Access-Control-Allow-Headers: * ");
        header("Access-Control-Allow-Methods: GET, POST");
    }
    public function index() {
        echo 'test';
    }
 public function getOrderId()
{

		//header('Content-Type: application/json');

		$keyId = 'lp1Rxd';
		$keySecret = 'd16d1d5774718f9b031bcff20fe09f78536104df7a9588788b1371fa52f1b858';

		$url = "https://api.razorpay.com/v1/orders";

		$data = [
			"amount" => 50000,
			"currency" => "INR",
			"receipt" => "rect001",
			
		];

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_USERPWD, $keyId . ":" . $keySecret);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Content-Type: application/json"
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			echo json_encode([
				"success" => false,
				"error" => curl_error($ch)
			]);
			curl_close($ch);
			exit;
		}

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($httpCode === 200) {
			echo json_encode([
				"success" => true,
				"order" => json_decode($response, true)
			]);
		} else {
			echo json_encode([
				"success" => false,
				"error" => json_decode($response, true)
			]);
		}
}
    function getOrderId1()
{
    $keyId = 'ECS7AF';
    $keySecret = 'DmygsOwkzusxJpE8Lju5Y3LS4Ds7qDpd';

    $url = "https://api.razorpay.com/v1/orders";

    $data = [
        "amount" => 5, // amount in paise
        "currency" => "INR",
        "receipt" => "recp001",
                
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, $keyId . ":" . $keySecret);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            "success" => false,
            "error" => $error
        ];
    }

    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        "success" => ($httpStatus === 200),
        "status" => $httpStatus,
        "response" => json_decode($response, true)
    ];
}

}
