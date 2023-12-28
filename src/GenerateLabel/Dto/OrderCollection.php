<?php

namespace AstrotechLabs\MelhorEnvio\GenerateLabel\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class OrderCollection extends CollectionBase
{
    protected function className(): string
    {
        return Order::class;
    }
}
