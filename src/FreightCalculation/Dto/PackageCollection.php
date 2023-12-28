<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class PackageCollection extends CollectionBase
{
    protected function className(): string
    {
        return Package::class;
    }

    public function toArray(): array
    {
        $items = get_object_vars($this);
        $packages = [];
        foreach ($items['items'] as $key => $item) {
            $packages[$key] = $item->toArray();
        }
        return $packages;
    }
}
