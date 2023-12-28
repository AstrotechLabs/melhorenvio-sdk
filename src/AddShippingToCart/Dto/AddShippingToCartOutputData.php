<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class AddShippingToCartOutputData implements JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $protocol,
        public readonly int $serviceId,
        public readonly float $price,
        public readonly int $deliveryMin,
        public readonly int $deliveryMax,
        public readonly string $status,
        public readonly array $payloadDetails
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
