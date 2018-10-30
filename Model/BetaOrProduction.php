<?php

class Rayms_OrderEventsBroadcaster_Model_BetaOrProduction
{

    public function toOptionArray()
    {
        return [['value' => 'disabled', 'label' => __('Disable')], ['value' => 'test', 'label' => __('Test')], ['value' => 'production', 'label' => __('Production')],];

    }
}
