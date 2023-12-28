<?php

namespace AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class OrderCollection extends CollectionBase
{
    protected function className(): string
    {
        return Order::class;
    }

    public function toArray(): array
    {
        $items = get_object_vars($this);
        $orders = [];
        foreach ($items['items'] as $key => $item) {
            $orders[$key] = $item->toArray();
        }
        return $orders;
    }
}
