<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class AddShippingToCartInputData implements JsonSerializable
{
    public function __construct(
        public readonly int $service,
        public readonly FromData $from,
        public readonly ToData $to,
        public readonly ProductCollection $products,
        public readonly VolumeCollection $volumes,
        public readonly OptionsData $options,
        public readonly int|string $agency = '',
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
