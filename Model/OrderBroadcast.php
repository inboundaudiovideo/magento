<?php 


class Rayms_OrderEventsBroadcaster_Model_OrderBroadcast
{

    const BETA_BROADCAST_ENDPOINT    = 'https://betaproaudio.herokuapp.com/webhooks/magento';
    const PROD_BROADCAST_ENDPOINT    = 'https://proaudio.com/webhooks/magento';
    const SECRET_KEY = 'mysecret';
    const CACHE_TAG = 'inbound_av_cache';
    const CONFIG_SECRET_KEY = 'ordereventsbroadcaster/general/secret_key';
    const CONFIG_STATUS_MODE = 'ordereventsbroadcaster/general/status_mode';
  
    public function broadcastOrderEvent(array $orderData)
    {

        $orderJsonData = json_encode(['magento_webhook_order_data' => $orderData]);
        $this->sendRequestViaCurl($orderJsonData);
    }

    public function sendRequestViaCurl($data)
    {

        Mage::log("sending curl request... ");
        $secretKey =  Mage::getStoreConfig(self::SECRET_KEY);
        $hash = base64_encode(hash_hmac('sha256', $data, $secretKey, true));
        $headers = array(

            'Content-Type'          => 'application/json',                                                                                
            'Content-Length'        => strlen($data),
            'X-Magento-Hmac-SHA256' => $hash,
            'X-Magento-Domain'      => 'mydomain.com'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getRequestUrl());
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HEADER  , true);  
        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
        Mage::log("Curl headers..." . json_encode($headers));                       
        $result = curl_exec($curl);
        $response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        Mage::log("Curl response..." . $response);
        if ($err) {
            
            Mage::log("Curl error..." . $err);
        }
        curl_close($curl);

    }
    
    public function getRequestUrl() : string 
    {

        $statusMode =  Mage::getStoreConfig(self::CONFIG_STATUS_MODE);
        
        Mage::log("Status mode : " . $statusMode);

        if ($statusMode == 'beta') {

            return self::BETA_BROADCAST_ENDPOINT;
        }
        
        return self::PROD_BROADCAST_ENDPOINT;
    }
    

}

