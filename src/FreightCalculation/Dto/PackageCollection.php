<?php

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class PackageCollection extends CollectionBase
{
    protected function className(): string
    {
        return Package::class;
    }
}
