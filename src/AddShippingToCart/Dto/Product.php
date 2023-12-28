<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class Product implements JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly string $quantity = '',
        public readonly string $unitaryValue = '',
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
