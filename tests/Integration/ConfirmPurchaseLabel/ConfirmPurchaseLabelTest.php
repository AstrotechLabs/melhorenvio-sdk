<?php

declare(strict_types=1);

namespace Tests\Integration\ConfirmPurchaseLabel;

use Tests\TestCase;
use Tests\Trait\HttpClientMock;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto\Order;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto\InputData;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto\OrderCollection;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\ConfirmPurchaseLabel;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\MelhorEnvioCheckoutLabelException;

final class ConfirmPurchaseLabelTest extends TestCase
{
    use HttpClientMock;

    public function testConfirmingPaymentOfTheLabel()
    {

        $confirmPurchaseLabel = new ConfirmPurchaseLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $confirmPurchaseLabel->confirmPurchase(
            new InputData(
                orders: new OrderCollection(
                    [new Order(
                        key: '9af3f99a-301e-4239-9c3d-7cb7e7bb3825'
                    )
                    ]
                )
            )
        );
        $this->assertNotEmpty($result->purchase);
        $this->assertNotEmpty($result->payloadDetails);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioCheckoutLabelException::class);
        $this->expectExceptionMessage('O campo orders deve ter pelo menos 1 itens.');
        $this->expectExceptionCode(400);

        $confirmPurchaseLabel = new ConfirmPurchaseLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $confirmPurchaseLabel->confirmPurchase(new InputData(
            orders: new OrderCollection(
                [new Order(
                    key: '67173a6e-2955-4c1c-bf94-9ef6fd399a12'
                )
                ]
            )
        ));
    }

    public function testItShouldThrowAnErrorWhenTheOrderIdIsIncorrect()
    {
        $this->expectException(MelhorEnvioCheckoutLabelException::class);
        $this->expectExceptionMessage('[error: orders.0] - O campo orders.0 deve ter pelo menos 36 caracteres.');
        $this->expectExceptionCode(422);

        $confirmPurchaseLabel = new ConfirmPurchaseLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $confirmPurchaseLabel->confirmPurchase(new InputData(
            orders: new OrderCollection(
                [new Order(
                    key: 'assdasassas-2955-4c1c-bf94-9ef6fd399a12'
                )
                ]
            )
        ));
    }
}