<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto;

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
            $orders[$key] = $item->key;
        }
        return $orders;
    }
}
