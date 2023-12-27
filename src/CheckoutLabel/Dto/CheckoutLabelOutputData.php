<?php

namespace AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto;

use JsonSerializable;

final class CheckoutLabelOutputData implements JsonSerializable
{
    public function __construct(
        public readonly array $checkoutDetail
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
