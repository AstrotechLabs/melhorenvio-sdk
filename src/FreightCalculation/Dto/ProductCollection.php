<?php

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class ProductCollection extends CollectionBase
{
    protected function className(): string
    {
        return Products::class;
    }
}
