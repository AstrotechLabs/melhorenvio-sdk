<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\GenerateLabel\Dto;

use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;
use JsonSerializable;

final class GenerateLabelInputData implements JsonSerializable
{
    public function __construct(
        public readonly OrderCollection $orders
    ) {
        if (!$this->orders->count()) {
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
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
