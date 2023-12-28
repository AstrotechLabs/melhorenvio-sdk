<?php

namespace AstrotechLabs\MelhorEnvio\CheckoutLabel;

use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\InputData;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\OutputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

final class CheckoutLabel
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

    public function confirmPushase(InputData $input): OutputData
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->accessToken}",
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
            $response = $this->httpClient->post("/api/v2/me/shipment/checkout", [
                'headers' => $headers,
                'json' => $body
            ]);
            $responsePayload = json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);

            throw new MelhorEnvioCheckoutLabelException(
                code: $e->getCode(),
                key: array_key_first($responsePayload['errors']),
                description: $responsePayload['message'],
                responsePayload:$responsePayload
            );
        }

        return new OutputData(
            purchase: $responsePayload['purchase'],
            payloadDetail: $responsePayload
        );
    }
}
