<?php

namespace AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto;

use JsonSerializable;

final class CheckoutLabelOutputData implements JsonSerializable
{
    public function __construct(
        public readonly array $purchase,
        public readonly array $payloadDetail,
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
