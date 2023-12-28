<?php

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use AstrotechLabs\MelhorEnvio\FreightCalculation\MelhorEnvioFreightCalculationException;
use JsonSerializable;

class FromData implements JsonSerializable
{
    public function __construct(
        public readonly string $postalCode,
    ) {
        if (empty($this->postalCode)) {
            throw new MelhorEnvioFreightCalculationException(
                code: 400,
                key: "from.postal code",
                description: "O campo postal code não pode ser vazio",
                responsePayload: []
            );
        }

        if (!preg_match('/^[0-9]+$/', $this->postalCode)) {
            throw new MelhorEnvioFreightCalculationException(
                code: 400,
                key: "from.postal code",
                description: "O campo postal code só pode conter numeros",
                responsePayload: []
            );
        }
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
