<?php

namespace Integration\GenerateLabel;

use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\GenerateLabelInputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\GenerateLabel;
use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;

class GeneralLabelTest extends TestCase
{
    use HttpClientMock;

    public function testLookingForGeneralLabel()
    {

        $generateLabel = new GenerateLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $generateLabel->generating(new GenerateLabelInputData(
            orders:["9af0f5df-52ca-4d93-9da3-59ee5cbad865"]
        ));

        $this->assertNotEmpty($result->orders);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioGenerateException::class);
        $this->expectExceptionCode(422);

        $checkoutLabel = new GenerateLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $checkoutLabel->generating(new GenerateLabelInputData(
            orders: []
        ));
    }
}
