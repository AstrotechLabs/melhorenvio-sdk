<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\OutputData;

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

    public function calculate(InputData $input): OutputData
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->accessToken}",
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent
        ];

        try {
            $response = $this->httpClient->get("/api/v2/me/shipment/calculate", [
                'headers' => $headers,
                'json' => $input->toArray()
            ]);

            $responsePayload = json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);
            $key = isset($responsePayload['errors']) ? array_key_first($responsePayload['errors']) : "Request Error";
            $description = isset($responsePayload['message']) ? $responsePayload['message'] : $responsePayload['error'];
            throw new MelhorEnvioFreightCalculationException(
                code: $e->getCode(),
                key: $key,
                description: $description,
                responsePayload:$responsePayload
            );
        }

        return new OutputData(
            deliveryDetails: $responsePayload,
        );
    }
}
