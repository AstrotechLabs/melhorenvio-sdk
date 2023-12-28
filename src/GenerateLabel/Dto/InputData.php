<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\GenerateLabel\Dto;

use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;
use JsonSerializable;

use function PHPUnit\Framework\isEmpty;

final class InputData implements JsonSerializable
{
    public function __construct(
        public readonly OrderCollection $orders
    ) {
        if (isEmpty($this->orders)) {
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
