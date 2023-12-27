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

            $body = [
                "from" => ["postal_code" => preg_replace("/[^0-9]/", "", $input->from)],
                "to" => ["postal_code" => preg_replace("/[^0-9]/", "", $input->to)],
                ...$input->extra
            ];

            $fieldProduct = ["id", "width", "height", "length", "weight", "insurance_value", "quantity"];
            if (isset($input->extra['products'])) {
                foreach ($input->extra['products'] as $key => $product) {
                    foreach ($fieldProduct as $field) {
                        if (!isset($product[$field]) || empty($product[$field])) {
                            throw new MelhorEnvioFreightCalculationException(
                                code: 422,
                                key: $field,
                                description: "O campo products.{$key}.{$field} é obrigatório.",
                                responsePayload:[]
                            );
                        }
                    }
                }
            }
            $fieldPackage = ["height", "width", "length", "weight"];
            if (isset($input->extra['package'])) {
                foreach ($fieldPackage as $field) {
                    if (!isset($input->extra['package'][$field]) || empty($input->extra['package'][$field])) {
                        throw new MelhorEnvioFreightCalculationException(
                            code: 422,
                            key: "package.{$field}",
                            description: "O campo package.{$field} é obrigatório.",
                            responsePayload:[]
                        );
                    }
                }
            }
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

            return new FreightCalculationOutputData($responsePayload);
    }
}
