<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\GenerateLabel\Dto;

use JsonSerializable;
use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;

class Order implements JsonSerializable
{
    public function __construct(
        public readonly string $key,
    ) {
        if (empty($this->key)) {
            throw new MelhorEnvioGenerateException(
                code: 400,
                key: "key",
                description: "a key da order é obrigatória",
                responsePayload:[]
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
