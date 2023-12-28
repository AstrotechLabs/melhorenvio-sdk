<?php

namespace AstrotechLabs\MelhorEnvio\GenerateLabel;

use AstrotechLabs\MelhorEnvio\AddShippingToCart\MelhorEnvioAddShippingToCartException;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\GenerateLabelInputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\GenerateLabelOutputData;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

final class GenerateLabel
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

    public function generate(GenerateLabelInputData $input): GenerateLabelOutputData
    {
            $headers = [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $this->accessToken",
                'Content-Type' => 'application/json',
                'User-Agent' => $this->userAgent
            ];

            $orders = [];
            $input->orders->map(function ($order) use (&$orders) {
                $orders[] = $order->key;
            });

            $body = [
                "orders" => $orders,
            ];

            try {
                $response = $this->httpClient->post("/api/v2/me/shipment/generate", [
                    'headers' => $headers,
                    'json' => $body
                ]);
                $responsePayload = json_decode($response->getBody()->getContents(), true);
            } catch (ClientException $e) {
                $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);

                throw new MelhorEnvioGenerateException(
                    code: $e->getCode(),
                    key: array_key_first($responsePayload['errors']),
                    description: $responsePayload['message'],
                    responsePayload:$responsePayload
                );
            }

            return new GenerateLabelOutputData(
                details: $responsePayload
            );
    }
}
