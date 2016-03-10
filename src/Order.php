<?php
namespace LegalThings\SDK;
use GuzzleHttp\Client;

class Order
{
    public function __construct(){}

    public function postTransaction($token, $serviceId) {
        $client = new Client([]);
        $ip = $_SERVER['REMOTE_ADDR'];
        try {
            $response = $client->request('POST', 'https://rest-api.pay.nl/v5/Transaction/start/json?', [
                'json' => [
                    'token' => $token, 
                    'serviceId' => $serviceId,
                    'amount' => 155,
                    'finishUrl' => 'https://www.pay.nl/demo_ppt/finish_url',
                    'paymentOptionId' => 10,
                    'ipAddress' => $ip,
                    'transaction' => [
                        'orderExchangeUrl' => 'http://localhost:8079/legalthings-shop/public'
                    ]
                ]
            ]);
        } catch (RequestException $e) {
            echo 'Uh oh! ' . $e->getMessage();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }

        $data = $response->getBody();
        $obj = json_decode($data);

        return $obj;
    }

    public function postPaymentAPI($sessionId, $licenseId, $organizationId, $returnURL) {
        $client = new Client();
        $data = [
            'product' => $licenseId, 
            'type' => 'license',
            'organization' => $organizationId,
            'returnURL' => $returnURL
        ];

        $headers = [
            'X-Session' => $sessionId
        ];
        try {
            $response = $client->request('POST', 'http://firm24.docarama.com/service/license/payment/start', [
                    'headers' => $headers,
                    'json' => $data
            ]);
        } catch (RequestException $e) {
            echo 'Uh oh! ' . $e->getMessage();
                if ($e->hasResponse()) {
                    echo $e->getResponse();
                }
        }
        
        $data = $response->getBody();
        $obj = json_decode($data);

        return $obj;
    }
}
