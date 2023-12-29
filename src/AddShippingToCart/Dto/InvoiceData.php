<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

final class InvoiceData implements JsonSerializable
{
    public function __construct(
        public readonly string $key
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
