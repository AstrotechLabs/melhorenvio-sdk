<?php

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\InvoiceData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\TagsData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\MelhorEnvioAddShippingToCartException;
use JsonSerializable;

final class OptionsData implements JsonSerializable
{
    public function __construct(
        public readonly bool $receipt = false,
        public readonly bool $ownHand = false
    ) {
    }

    public function toArray(): array
    {
        $data = get_object_vars($this);
        $changedData = [];
        foreach ($data as $key => $value) {
            $changedData[$this->camelCaseToUnderscores($key)] = $value;
        }
        return $changedData;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function camelCaseToUnderscores(string $string, bool $capitalizeFirst = false): string
    {
        $string = mb_strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));

        if (!$capitalizeFirst) {
            $string = lcfirst($string);
        }

        return $string;
    }
}
