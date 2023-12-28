<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use JsonSerializable;

class Product implements JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly int $width,
        public readonly int $height,
        public readonly int $length,
        public readonly int $weight,
        public readonly float $insurance_value,
        public readonly int $quantity
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
