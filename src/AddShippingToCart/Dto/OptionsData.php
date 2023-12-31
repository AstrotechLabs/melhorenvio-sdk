<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

final class OptionsData implements JsonSerializable
{
    public function __construct(
        public readonly float $insuranceValue,
        public readonly bool $nonCommercial = true,
        public readonly bool $receipt = false,
        public readonly bool $ownHand = false,
        public readonly bool $reverse = false,
        public readonly string $platform = '',
        public readonly InvoiceData|null $invoice = null,
        public readonly TagsData|null $tags = null,
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
