<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use AstrotechLabs\MelhorEnvio\Shared\Utils\CollectionBase;

class VolumeCollection extends CollectionBase
{
    protected function className(): string
    {
        return Volumes::class;
    }
}
