<?php

namespace Integration\GenerateLabel;

use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\GenerateLabelInputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\Order;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\OrderCollection;
use AstrotechLabs\MelhorEnvio\GenerateLabel\GenerateLabel;
use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;

class GenerateLabelTest extends TestCase
{
    use HttpClientMock;

    public function testLookingForGeneralLabel()
    {

        $generateLabel = new GenerateLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $generateLabel->generate(new GenerateLabelInputData(
            orders:new OrderCollection(
                [new Order(key: "9af3f99a-301e-4239-9c3d-7cb7e7bb3825")]
            )
        ));

        $this->assertNotEmpty($result->details);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioGenerateException::class);
        $this->expectExceptionMessage('O campo orders deve ter pelo menos 1 itens.');
        $this->expectExceptionCode(400);

        $checkoutLabel = new GenerateLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $checkoutLabel->generate(new GenerateLabelInputData(
            orders: new OrderCollection([]),
        ));
    }

    public function testItShouldThrowAnErrorWhenTheOrderIdIsIncorrect()
    {
        $this->expectException(MelhorEnvioGenerateException::class);
        $this->expectExceptionMessage('O campo orders.0 deve ter pelo menos 36 caracteres.');
        $this->expectExceptionCode(422);

        $checkoutLabel = new GenerateLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $checkoutLabel->generate(new GenerateLabelInputData(
            orders: new OrderCollection(
                [
                    new Order(
                        key: "salksdmal"
                    )
                ]
            ),
        ));
    }
}
