<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation;

use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FreightCalculationInputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FreightCalculationOutputData;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

final class FreightCalculation
{
    private Client $httpClient;

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
    }

    public function calculate(FreightCalculationInputData $input): FreightCalculationOutputData
    {
            $headers = [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => 'application/json',
                'User-Agent' => $this->userAgent
            ];

            $productOrPackage = [];
            if ($input->isProduct) {
                $input->products->map(function ($product) use (&$productOrPackage) {
                    $productOrPackage['products'][] = $product->toArray();
                });
            } else {
                $input->package->map(function ($package) use (&$productOrPackage) {
                    $productOrPackage['package'][] = $package->toArray();
                });
            }
            $body = array_filter([
                "from" => ["postal_code" => preg_replace("/[^0-9]/", "", $input->from->postalCode)],
                "to" => ["postal_code" => preg_replace("/[^0-9]/", "", $input->to->postalCode)],
                "options" => $input->options?->toArray(),
                "service" => $input->services,
                ...$productOrPackage
            ]);
        try {
                $response = $this->httpClient->get("/api/v2/me/shipment/calculate", [
                    'headers' => $headers,
                    'json' => $body
                    ]);

                $responsePayload = json_decode($response->getBody()->getContents(), true);

        } catch (ClientException $e) {
                $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);
                throw new MelhorEnvioFreightCalculationException(
                    code: $e->getCode(),
                    key: array_key_first($responsePayload['errors']),
                    description: $responsePayload['message'],
                    responsePayload:$responsePayload
                );
        }

            return new FreightCalculationOutputData(
                deliveryDetail: $responsePayload,
            );
    }
}
