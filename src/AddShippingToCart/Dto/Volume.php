<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class Volume implements JsonSerializable
{
    public function __construct(
        public readonly int $height,
        public readonly int $width,
        public readonly int $length,
        public readonly int $weight
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
