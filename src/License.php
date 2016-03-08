<?php
namespace LegalThings\SDK;
use GuzzleHttp\Client;

class License
{
    public function __construct(){}

    public function getLicenses() {
        $client = new Client([]);
        try {
            $response = $client->request('GET', 'http://docarama-legallicense-master.elasticbeanstalk.com/licenses');
            $data = $response->getBody();
            $obj = json_decode($data);
        } catch(Exception $e) {
            echo 'Uh oh! ' . $e->getMessage();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
        return $obj;
    }   

    public function getLicense($sessionId, $licenseId) {
        if (!$sessionId) throw new InvalidArgumentException("sessionId not specified");
        if (!$licenseId) throw new InvalidArgumentException("licenseId not specified");
        $client = new Client([]);
        try {
            $response = $client->get('http://docarama-legallicense-master.elasticbeanstalk.com/licenses/' . $licenseId, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Session' => $sessionId
                ]
            ]);
            $data = $response->getBody();
            $obj = json_decode($data);
        } catch(Exception $e) {
            echo 'Uh oh! ' . $e->getMessage();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
        return $obj;
    }
}
