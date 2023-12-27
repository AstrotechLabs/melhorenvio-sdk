<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use JsonSerializable;

final class FreightCalculationInputData implements JsonSerializable
{
    public function __construct(
        public readonly string $to,
        public readonly string $from,
        public readonly array $extra
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
