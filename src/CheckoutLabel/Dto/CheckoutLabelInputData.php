<?php

namespace AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto;

use AstrotechLabs\MelhorEnvio\CheckoutLabel\MelhorEnvioCheckoutLabelException;
use JsonSerializable;

final class CheckoutLabelInputData implements JsonSerializable
{
    public function __construct(
        public readonly OrderCollection $orders,
    ) {
        if (!$this->orders->count()) {
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
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
