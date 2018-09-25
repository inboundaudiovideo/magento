<?php

class Rayms_OrderEventsBroadcaster_Model_BetaOrProduction
{

    public function toOptionArray()
    {
        return [['value' => 'beta', 'label' => __('Beta Mode')], ['value' => 'production', 'label' => __('Production Mode')],];

    }
}
