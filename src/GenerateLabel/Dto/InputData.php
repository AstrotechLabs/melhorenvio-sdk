<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\GenerateLabel\Dto;

use JsonSerializable;
use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;

final class InputData implements JsonSerializable
{
    public function __construct(
        public readonly OrderCollection $orders
    ) {
        if ($this->orders->isEmpty()) {
            throw new MelhorEnvioGenerateException(
                code:400,
                key:"orders",
                description: "O campo orders deve ter pelo menos 1 itens.",
                responsePayload:[]
            );
        }
    }

    public function toArray(): array
    {
        return [
            "orders" => $this->orders->toArray()
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
