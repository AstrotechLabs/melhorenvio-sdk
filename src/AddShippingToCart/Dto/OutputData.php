<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class OutputData implements JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $protocol,
        public readonly int $serviceId,
        public readonly float $price,
        public readonly int $deliveryMinDays,
        public readonly int $deliveryMaxDays,
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
