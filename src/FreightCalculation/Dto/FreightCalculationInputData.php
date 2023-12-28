<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation\Dto;

use AstrotechLabs\MelhorEnvio\CheckoutLabel\MelhorEnvioCheckoutLabelException;
use JsonSerializable;

final class FreightCalculationInputData implements JsonSerializable
{
    public function __construct(
        public readonly ToData $to,
        public readonly FromData $from,
        public readonly ProductCollection|null $products = null,
        public readonly PackageCollection|null $package = null,
        public readonly OptionsData|null $options = null,
        public readonly string|null $services = null,
        public readonly bool $isProduct = true,
    ) {
        if ($this->isProduct && empty($this->products)) {
            throw new MelhorEnvioCheckoutLabelException(
                code:400,
                key:"products",
                description: "O campo products deve ter pelo menos 1 itens.",
                responsePayload:[]
            );
        }

        if (!$this->isProduct && empty($this->package   )) {
            throw new MelhorEnvioCheckoutLabelException(
                code:400,
                key:"package",
                description: "O campo package deve ter pelo menos 1 itens.",
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
