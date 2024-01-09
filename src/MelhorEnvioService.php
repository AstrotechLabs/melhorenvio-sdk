<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio;

use AstrotechLabs\MelhorEnvio\GenerateLabel\GenerateLabel;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\AddShippingToCart;
use AstrotechLabs\MelhorEnvio\FreightCalculation\FreightCalculation;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\ConfirmPurchaseLabel;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\InputData as GenerateLabelInput;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto\InputData as ConfirmPurchaseLabelInput;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartItem as AddShippingToCartInput;
use GuzzleHttp\Client;

final class MelhorEnvioService
{
    private Client $httpClient;
    private array $headers;

    public function __construct(
        private readonly string $accessToken,
        private readonly string $userAgent,
        private readonly bool $isSandbox = false
    ) {
        $this->httpClient = new Client(
            [
                'base_uri' => $this->isSandbox ? 'https://sandbox.melhorenvio.com.br' : 'https://app.melhorenvio.com.br'
            ]
        );

        $this->headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->accessToken}",
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent
        ];
    }

    public function addShippingToCart(AddShippingToCartInput $inputData)
    {
        $addShippingToCart = new AddShippingToCart(
            httpClient: $this->httpClient,
            headers: $this->headers
        );
        return $addShippingToCart->add($inputData)->toArray();
    }

    public function confirmPurchase(ConfirmPurchaseLabelInput $inputData)
    {
        $confirmPurchaseLabel = new ConfirmPurchaseLabel(
            httpClient: $this->httpClient,
            headers: $this->headers
        );
        return $confirmPurchaseLabel->confirmPurchase($inputData)->toArray();
    }

    public function freightCalculate(InputData $inputData)
    {
        $freightCalculate = new FreightCalculation(
            httpClient: $this->httpClient,
            headers: $this->headers
        );
        return $freightCalculate->calculate($inputData)->toArray();
    }

    public function generateLabel(GenerateLabelInput $inputData)
    {
        $generateLabel = new GenerateLabel(
            httpClient: $this->httpClient,
            headers: $this->headers
        );
        return $generateLabel->generate($inputData)->toArray();
    }
}
