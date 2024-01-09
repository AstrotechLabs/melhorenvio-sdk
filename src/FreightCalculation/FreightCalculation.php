<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\FreightCalculation;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\OutputData;

final class FreightCalculation
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

    public function calculate(InputData $input): OutputData
    {

        try {
            $response = $this->httpClient->get("/api/v2/me/shipment/calculate", [
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
