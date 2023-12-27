<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\AddShippingToCart;

use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartInputData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartOutputData;
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

    public function adding(AddShippingToCartInputData $input): AddShippingToCartOutputData
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->accessToken}",
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent
        ];

        if (
            !array_key_exists("document", $input->from) && !array_key_exists("company_document", $input->from)
        ) {
                throw new MelhorEnvioAddShippingToCartException(
                    code:422,
                    key:"from.document or from.company_document",
                    description: "O campo cnpj ou cpf devem ser declarados.",
                    responsePayload:[]
                );
        }

        if (
            !array_key_exists("document", $input->to) && !array_key_exists("company_document", $input->to)
        ) {
            throw new MelhorEnvioAddShippingToCartException(
                code:422,
                key:"to.document or to.company_document",
                description: "O campo cnpj ou cpf devem ser declarados.",
                responsePayload:[]
            );
        }

        $body = [
            "service" => $input->service,
            "from" => $input->from,
            "to" => $input->to,
            "products" => $input->products,
            "volumes" => $input->volumes,
            "options" => $input->options,
            ...$input->extras
        ];

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
        return new AddShippingToCartOutputData($responsePayload);
    }
}
