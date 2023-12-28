<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio;

use AstrotechLabs\MelhorEnvio\CheckoutLabel\CheckoutLabel;
use AstrotechLabs\MelhorEnvio\GenerateLabel\GenerateLabel;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\AddShippingToCart;
use AstrotechLabs\MelhorEnvio\FreightCalculation\FreightCalculation;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\InputData as CheckoutLabelInput;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\InputData as GenerateLabelInput;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartItem as AddShippingToCartInput;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData as FreightCalculationInput;

final class MelhorEnvioService
{
    public function __construct(
        private readonly string $accessToken,
        private readonly string $userAgent,
        private readonly bool $isSandbox = false
    ) {
    }

    public function addShippingToCart(AddShippingToCartInput $inputData)
    {
        $addShippingToCart = new AddShippingToCart(
            accessToken: $this->accessToken,
            userAgent: $this->userAgent,
            isSandbox: $this->isSandbox
        );
        return $addShippingToCart->add($inputData)->toArray();
    }

    public function checkoutLabel(CheckoutLabelInput $inputData)
    {
        $addShippingToCart = new CheckoutLabel(
            accessToken: $this->accessToken,
            userAgent: $this->userAgent,
            isSandbox: $this->isSandbox
        );
        return $addShippingToCart->confirmPushase($inputData)->toArray();
    }

    public function freightCalculate(FreightCalculationInput $inputData)
    {
        $addShippingToCart = new FreightCalculation(
            accessToken: $this->accessToken,
            userAgent: $this->userAgent,
            isSandbox: $this->isSandbox
        );
        return $addShippingToCart->calculate($inputData)->toArray();
    }

    public function generateLabel(GenerateLabelInput $inputData)
    {
        $addShippingToCart = new GenerateLabel(
            accessToken: $this->accessToken,
            userAgent: $this->userAgent,
            isSandbox: $this->isSandbox
        );
        return $addShippingToCart->generate($inputData)->toArray();
    }
}
