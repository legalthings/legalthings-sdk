<?php
namespace LegalThings\SDK;
use GuzzleHttp\Client;

class Template
{
    protected $sessionId;

    public function __construct($sessionId)
    {
        if (!$sessionId) throw new InvalidArgumentException("sessionId not specified");
        $this->sessionId = $sessionId;
    }

    public function getTemplates() {
        $client = new Client([]);
        try {
            $response = $client->get('http://firm24.docarama.com/service/docx/templates', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Session' => $this->sessionId
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

    public function getTemplate($templateId) {
        if (!$templateId) throw new InvalidArgumentException("templateId not specified");
        $client = new Client([]);
        try {
            $response = $client->get('http://firm24.docarama.com/service/docx/templates/' . $templateId, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Session' => $this->sessionId
                ]
            ]);
            
            $data = $response->getBody();
            $obj = json_decode($data);
        } catch{
            echo 'Uh oh! ' . $e->getMessage();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
        return $obj;
    }
}
