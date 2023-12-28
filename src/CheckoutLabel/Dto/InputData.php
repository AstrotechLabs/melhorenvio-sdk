<?php

namespace AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto;

use AstrotechLabs\MelhorEnvio\CheckoutLabel\MelhorEnvioCheckoutLabelException;
use JsonSerializable;

use function PHPUnit\Framework\isEmpty;

final class InputData implements JsonSerializable
{
    public function __construct(
        public readonly OrderCollection $orders,
    ) {
        if (isEmpty($this->orders)) {
            throw new MelhorEnvioCheckoutLabelException(
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
