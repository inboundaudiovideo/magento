<?php


class Rayms_OrderEventsBroadcaster_Model_Observer
{
    const CONFIG_STATUS_MODE = 'ordereventsbroadcaster/general/status_mode';

    public function broadCastForOrderChanges(Varien_Event_Observer $observer)
    {
        if (Mage::getStoreConfig(self::CONFIG_STATUS_MODE) == 'disabled') {
            // dont trigger
            Mage::log("disabled");
            return false;
        }
        
        $event = $observer->getEvent();
        $order = $event->getOrder();

        $orderId = $order->getIncrementId(); 

        $customer = $order->getCustomer();
        $productId = $order->getProductId();  
        $customerId = $order->getCustomerId();
        $orderItem = $order->getItem();

        Mage::log("order_data start");
        Mage::log( $order->getEmail() );
        Mage::log( $orderItem );
        Mage::log( $customerId );
        Mage::log("order_data ends");
        $customerData = Mage::getModel('customer/customer')->load($customerId);
    
        Mage::log("customer_data start");
        Mage::log( $customerData );

        $lineItems = [];
      
        foreach ($order->getAllItems() as $item) {
          
            $lineItem = [

                'product_id'        =>      $item->getProductId(),
                'product_sku'       =>      $item->getSku(),
                'product_name'      =>      $item->getName(),
                'product_price'     =>      $item->getPrice(),
                'ordered_qty'       =>      $item->getQtyOrdered()
    
            ];
            
            array_push($lineItems, $lineItem);
        }

        Mage::log($lineItems);

        Mage::log(sprintf('Order Id :: %s ,Product Id :: %s Customer Id :: %s ',$orderId, $productId, $customerId));

        Mage::log('we are in cataloginventory frontend log ends ');

        $addressModel = Mage::getModel('rayms_ordereventsbroadcaster_model/address');
        $shippingAddress = $addressModel->setAddress($order->getShippingAddress())->getFullAddress();
        $billingAddress = $addressModel->setAddress($order->getBillingAddress())->getFullAddress();

        $orderParams = [

            'order_id'                      =>      $orderId,
            'order_status'                  =>      $order->getState(),
            'order_date'                    =>      $order->getCreatedAt(),
            'order_date_updated'            =>      $order->getUpdatedAt(),
            'shipping_method'               =>      $order->getShippingMethod(),
            'order_total'                   =>      $order->getGrandTotal(),
            'currency'                      =>      $order->getOrderCurrency()->getCode(),
            'customer_id'                   =>      $customerId,
            'customer_name'                 =>      $customerData->getName(),
            'customer_email'                =>      $order->getCustomerEmail(),
            'line_items'                    =>      $lineItems,
            'shipping_address'              =>      $shippingAddress,
            'billing_address'               =>      $billingAddress
  
        ];
        
        // echo json_encode($orderParams);
       
        Mage::log("order params :: " . json_encode(['magento_order_data' => $orderParams]));
        
        // broadcast the data from the event to a web hook
        Mage::getModel('rayms_ordereventsbroadcaster_model/orderbroadcast')->broadcastOrderEvent($orderParams);
        
        // log the successful placement of order
        Mage::log("order placed!");
    }
}