<?php 

namespace Rayms\OrderEventsBroadcaster\Model;

class OrderBroadcast {

    const BETA_ENDPOINT_FOR_NEW_ORDER       = 'https://betaproaudio.herokuapp.com/webhooks/magento';
    const PROD_ENDPOINT_FOR_ORDER_UPDATE    = 'https://proaudio.com/webhooks/magento';

    public function broadCastForNewOrder(){
        $this->sendRequest();
    }

    public function sendRequest(){

        $request = new \Zend\Http\Request();
        $request->setHeaders($this->getHeaders());
        $request->setUri(self::BETA_ENDPOINT_FOR_NEW_ORDER);
        $request->setMethod(\Zend\Http\Request::METHOD_GET);

        $params = new \Zend\Stdlib\Parameters([
        // 'searchCriteria' => '*'
        ]);

        $request->setQuery($params);

        $client = new \Zend\Http\Client();

        $options = [

            'adapter'       =>  'Zend\Http\Client\Adapter\Curl',
            'curloptions'   =>  [CURLOPT_FOLLOWLOCATION => true],
            'maxredirects'  =>  0,
            'timeout'       =>  30
        ];

        $client->setOptions($options);

        // send the request
        $response = $client->send($request);
    }

    public function broadCastForOrderChange(){
        
        $this->sendRequest();
        die("After saving order");
    }

    public function getHeaders(){

        $token = 'idontknowiftokenisnecessary';
        $httpHeaders = new \Zend\Http\Headers();
        return $httpHeaders->addHeaders([
            'x-magento-hmac-sha256' => '256Hash',
            'x-magento-domain'      => 'http://anawesomemagentostore.com',
            'Authorization'         => 'Bearer ' . $token,
            'Accept'                => 'application/json',
            'Content-Type'          => 'application/json'
        ]);

    }

}

