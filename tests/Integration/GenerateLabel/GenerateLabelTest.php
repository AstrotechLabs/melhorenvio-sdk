<?php

declare(strict_types=1);

namespace Tests\Integration\GenerateLabel;

use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\Order;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\InputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\OrderCollection;
use AstrotechLabs\MelhorEnvio\GenerateLabel\MelhorEnvioGenerateException;

class GenerateLabelTest extends TestCase
{
    use HttpClientMock;

    private MelhorEnvioService $service;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->service = new MelhorEnvioService(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );
    }

    public function testLookingForGeneralLabel()
    {
        $result = $this->service->generateLabel(new InputData(
            orders:new OrderCollection(
                [new Order(key: "9af3f99a-301e-4239-9c3d-7cb7e7bb3825")]
            )
        ));

        $this->assertNotEmpty($result['details']);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioGenerateException::class);
        $this->expectExceptionMessage('O campo orders deve ter pelo menos 1 itens.');
        $this->expectExceptionCode(400);

        $this->service->generateLabel(new InputData(
            orders: new OrderCollection([]),
        ));
    }

    public function testItShouldThrowAnErrorWhenTheOrderIdIsIncorrect()
    {
        $this->expectException(MelhorEnvioGenerateException::class);
        $this->expectExceptionMessage('O campo orders.0 deve ter pelo menos 36 caracteres.');
        $this->expectExceptionCode(422);

        $this->service->generateLabel(new InputData(
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
