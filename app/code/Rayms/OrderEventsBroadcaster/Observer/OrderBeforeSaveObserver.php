<?php 

namespace Rayms\OrderEventsBroadcaster\Observer;

class OrderBeforeSaveObserver implements \Magento\Framework\Event\ObserverInterface {
    
    public function __construct()
    {
      //Observer initialization code...
      //You can use dependency injection to get any class this observer may need.
    }
  
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
      //Observer execution code...
    //   $myEventData = $observer->getData('myEventData');
        //Additional observer execution code..
        die("Before saving order");
    }

}