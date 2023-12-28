<?php

namespace AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class OrderCollection extends CollectionBase
{
    protected function className(): string
    {
        return Order::class;
    }
}
