<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart;

use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\InputData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\OutputData;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

final class AddShippingToCart
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

    public function add(InputData $input): OutputData
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->accessToken}",
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent
        ];

        $body = $input->toArray();

        try {
            $response = $this->httpClient->post("/api/v2/me/cart", [
                'headers' => $headers,
                'json' => $body
            ]);
            $responsePayload = json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);

            throw new MelhorEnvioAddShippingToCartException(
                code: $e->getCode(),
                key: array_key_first($responsePayload['errors']),
                description: $responsePayload['message'],
                responsePayload:$responsePayload
            );
        }
        return new OutputData(
            id: $responsePayload['id'],
            protocol: $responsePayload['protocol'],
            serviceId: $responsePayload['service_id'],
            price: $responsePayload['price'],
            deliveryMin: $responsePayload['delivery_min'],
            deliveryMax: $responsePayload['delivery_max'],
            status: $responsePayload['status'],
            payloadDetails: $responsePayload
        );
    }
}
