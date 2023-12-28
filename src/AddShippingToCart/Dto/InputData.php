<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto;

use JsonSerializable;

class InputData implements JsonSerializable
{
    public function __construct(
        public readonly int $service,
        public readonly FromData $from,
        public readonly ToData $to,
        public readonly ProductCollection $products,
        public readonly VolumeCollection $volumes,
        public readonly OptionsData $options,
        public readonly int|string $agency = '',
    ) {
    }

    public function toArray(): array
    {
        return [
            "service" => $this->service,
            "agency" => $this->agency,
            "from" => array_filter($this->from->toArray()),
            "to" => array_filter($this->to->toArray()),
            "products" => $this->products->toArray(),
            "volumes" => $this->volumes->toArray(),
            "options" => $this->options
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
