<?php
namespace LegalThings\SDK;
use GuzzleHttp\Client;

class Auth
{
    public function __construct(){}
    
    public function startSession($email, $password) {
        $client = new Client([]);

        try {
            $response = $client->request('POST', 'http://firm24.docarama.com/service/iam/sessions', [
                'json' => ['email' => $email, 'password' => $password]
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

    public function postSSORegisterAPI($sso_session, $user) {
        $client = new Client([]);
        try {
            $response = $client->request('POST', 'http://firm24.docarama.com/service/iam/sso/register?sso_session=' . $sso_session, [
                'json' => [
                    'user' => [
                        'first_name' => $user['first_name'], 
                        'last_name' => $user['last_name'], 
                        'email' => $user['email'],
                        'password' => $user['password']
                    ],
                    'organization' => [
                        "name" => $user['first_name'],
                        "type" => "client"
                    ],
                    'login' => true
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

    public function getUserAPI($userId, $sessionId) {
        $client = new Client([]);
        try {
            $response = $client->get('http://firm24.docarama.com/service/iam/users/' . $userId, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Session' => $sessionId
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
}
