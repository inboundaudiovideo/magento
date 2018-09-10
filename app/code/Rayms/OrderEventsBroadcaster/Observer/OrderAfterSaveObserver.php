<?php 

namespace Rayms\OrderEventsBroadcaster\Observer;

use Rayms\OrderEventsBroadcaster\Model\OrderBroadcast;

class OrderAfterSaveObserver implements \Magento\Framework\Event\ObserverInterface {

  private $orderBroadCastModel;
    
    public function __construct(OrderBroadcast $orderBroadCastModel)
    {
      $this->$orderBroadCastModel = $orderBroadCastModel;
      //Observer initialization code...
      //You can use dependency injection to get any class this observer may need.
    }
  
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
      //Observer execution code...
    //   $myEventData = $observer->getData('myEventData');
        //Additional observer execution code..
        $orderBroadCastModel->broadCastForOrderChange();
       

    }

}