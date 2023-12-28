<?php

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use AstrotechLabs\MelhorEnvio\AddShippingToCart\MelhorEnvioAddShippingToCartException;
use JsonSerializable;

final class ToData implements JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly string $postalCode,
        public readonly string $city,
        public readonly string $phone = '',
        public readonly string $email = '',
        public readonly string $companyDocument = '',
        public readonly string $document = '',
        public readonly string $stateRegister = '',
        public readonly string $complement = '',
        public readonly string $number = '',
        public readonly string $district = '',
        public readonly string $countryId = '',
        public readonly string $stateAbbr = '',
        public readonly string $note = '',
        public readonly bool $isDocument = false
    ) {
        if ($this->isDocument && empty($this->document)) {
            throw new MelhorEnvioAddShippingToCartException(
                code: 400,
                key: "to.document",
                description: "O campo CPF deve ser preenchido",
                responsePayload: []
            );
        }

        if (!$this->isDocument && empty($this->companyDocument)) {
            throw new MelhorEnvioAddShippingToCartException(
                code: 400,
                key: "to.companyDocument",
                description: "O campo CNPJ deve ser preenchido",
                responsePayload: []
            );
        }

        if (!preg_match('/^[0-9]+$/', $this->postalCode)) {
            throw new MelhorEnvioAddShippingToCartException(
                code: 400,
                key: "to.postal code",
                description: "O campo postal code só pode conter numeros",
                responsePayload: []
            );
        }
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