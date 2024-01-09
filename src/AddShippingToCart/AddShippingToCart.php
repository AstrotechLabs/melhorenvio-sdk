<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\OutputData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartItem;

final class AddShippingToCart
{
    /**
     * @param Client $httpClient
     * @param array $headers
     */

    public function __construct(
        private readonly Client $httpClient,
        private readonly array $headers
    ) {
    }

    public function add(AddShippingToCartItem $input): OutputData
    {

        try {
            $response = $this->httpClient->post("/api/v2/me/cart", [
                'headers' => $this->headers,
                'json' => $input->toArray()
            ]);
            $responsePayload = json_decode($response->getBody()->getContents(), true);
        } catch (
            ClientException
            | ServerException
            $e
        ) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);
            $key = isset($responsePayload['errors']) ? array_key_first($responsePayload['errors']) : "Request Error";
            $description = isset($responsePayload['message']) ? $responsePayload['message'] : $responsePayload['error'];

            throw new MelhorEnvioAddShippingToCartException(
                code: $e->getCode(),
                key: $key,
                description: $description,
                responsePayload:$responsePayload
            );
        }
        return new OutputData(
            id: $responsePayload['id'],
            protocol: $responsePayload['protocol'],
            serviceId: $responsePayload['service_id'],
            price: $responsePayload['price'],
            deliveryMinDays: $responsePayload['delivery_min'],
            deliveryMaxDays: $responsePayload['delivery_max'],
            status: $responsePayload['status'],
            payloadDetails: $responsePayload
        );
    }
}
