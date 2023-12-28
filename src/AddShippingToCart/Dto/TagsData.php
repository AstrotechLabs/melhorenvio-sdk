<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use AstrotechLabs\MelhorEnvio\AddShippingToCart\MelhorEnvioAddShippingToCartException;
use JsonSerializable;

final class TagsData implements JsonSerializable
{
    public function __construct(
        public readonly int $tag,
        public readonly string $url,
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
