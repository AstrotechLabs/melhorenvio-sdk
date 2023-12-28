<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class ProductCollection extends CollectionBase
{

    protected function className(): string
    {
        return Product::class;
    }

    public function toArray(): array
    {
        $items = get_object_vars($this);
        $products = [];
        foreach ($items['items'] as $key => $item) {
            $products[$key] = $item->toArray();
        }
        return $products;
    }
}
