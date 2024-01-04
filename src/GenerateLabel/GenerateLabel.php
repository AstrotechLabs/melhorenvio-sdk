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

    public function generate(InputData $input): OutputData
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $this->accessToken",
            'Content-Type' => 'application/json',
            'User-Agent' => $this->userAgent
        ];

        try {
            $response = $this->httpClient->post("/api/v2/me/shipment/generate", [
                'headers' => $headers,
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
