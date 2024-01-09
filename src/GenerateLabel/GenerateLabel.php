<?php

declare(strict_types=1);

namespace AstrotechLabs\MelhorEnvio\GenerateLabel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\InputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\OutputData;

final class GenerateLabel
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

    public function generate(InputData $input): OutputData
    {

        try {
            $response = $this->httpClient->post("/api/v2/me/shipment/generate", [
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
            throw new MelhorEnvioGenerateException(
                code: $e->getCode(),
                key: $key,
                description: $description,
                responsePayload:$responsePayload
            );
        }

        return new OutputData(
            details: $responsePayload
        );
    }
}
