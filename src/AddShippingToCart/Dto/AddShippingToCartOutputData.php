<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class AddShippingToCartOutputData implements JsonSerializable
{
    public function __construct(
        public readonly array $itemDetails
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
