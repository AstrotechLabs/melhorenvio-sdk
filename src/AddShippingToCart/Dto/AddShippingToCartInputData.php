<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class AddShippingToCartInputData implements JsonSerializable
{
    public function __construct(
        public readonly int $service,
        public readonly array $from,
        public readonly array $to,
        public readonly array $products,
        public readonly array $volumes,
        public readonly array $options,
        public readonly array $extras = [],
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