<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use JsonSerializable;

final class FreightCalculationOutputData implements JsonSerializable
{
    public function __construct(
        public readonly array $deliveryDetail
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
