<?php
// app/Services/MomoService.php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MomoService
{
    private $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $redirectUrl;
    private $ipnUrl;

    public function __construct()
    {
        $this->partnerCode = config('momo.partner_code');
        $this->accessKey = config('momo.access_key');
        $this->secretKey = config('momo.secret_key');
        $this->redirectUrl = config('momo.redirect_url');
        $this->ipnUrl = config('momo.ipn_url');
    }

    public function createPayment($orderId, $amount, $orderInfo)
    {
        $requestId = time() . "";
        $rawHash = "accessKey=" . $this->accessKey .
            "&amount=" . $amount .
            "&extraData=" .
            "&ipnUrl=" . $this->ipnUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $this->partnerCode .
            "&redirectUrl=" . $this->redirectUrl .
            "&requestId=" . $requestId .
            "&requestType=payWithATM";

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => "Test Store",
            'storeId' => 'MomoTestStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $this->redirectUrl,
            'ipnUrl' => $this->ipnUrl,
            'lang' => 'vi',
            'extraData' => '',
            'requestType' => 'payWithATM',
            'extraData' => '',  // Có thể để trống nhưng phải gửi
            'signature' => $signature
        ];

        $result = $this->execPostRequest($this->endpoint, json_encode($data));
        return json_decode($result, true);
    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            Log::error('cURL error', ['error' => $error_msg]);
        }

        curl_close($ch);

        Log::info('MoMo Request', ['url' => $url, 'data' => $data, 'response' => $result, 'http_code' => $httpCode]);

        return $result;
    }
}
