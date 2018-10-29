<?php

namespace Rayms\OrderEventsBroadcaster\Model\System\Config\Mode;

use Magento\Framework\Option\ArrayInterface;

class BetaOrProduction implements ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'disabled', 'label' => __('Disable')],['value' => 'test', 'label' => __('Test')], ['value' => 'production', 'label' => __('Production')],];
    }
}
