<?php
namespace LegalThings\SDK;
use GuzzleHttp\Client;

class License
{
    public function __construct(){}

    public function getLicensesOfOrganization($organizationId, $sessionId)
    {
        $client = new Client([]);
        try {
            $response = $client->get('http://firm24.docarama.com/service/license/organizations/' . $organizationId, [
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
        $body = $response->getBody();
        $data = json_decode($body);

        return $data;
    }

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
