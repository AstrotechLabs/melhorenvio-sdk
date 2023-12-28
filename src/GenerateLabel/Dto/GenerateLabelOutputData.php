<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\GenerateLabel\Dto;

use JsonSerializable;

final class GenerateLabelOutputData implements JsonSerializable
{
    public function __construct(
        public readonly array $details
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
