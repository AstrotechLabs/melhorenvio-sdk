<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class VolumeCollection extends CollectionBase
{
    protected function className(): string
    {
        return Volume::class;
    }

    public function toArray(): array
    {
        $items = get_object_vars($this);
        $volumes = [];
        foreach ($items['items'] as $key => $item) {
            $volumes[$key] = $item->toArray();
        }
        return $volumes;
    }
}
