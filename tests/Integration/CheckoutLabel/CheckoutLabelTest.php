<?php

declare(strict_types=1);

namespace CheckoutLabel;

use AstrotechLabs\MelhorEnvio\CheckoutLabel\CheckoutLabel;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\CheckoutLabelInputData;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\MelhorEnvioCheckoutLabelException;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;

final class CheckoutLabelTest extends TestCase
{
    use HttpClientMock;

    public function testLookingForFreightCalculation()
    {

        $checkoutLabel = new CheckoutLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $checkoutLabel->confirmingPushase(new CheckoutLabelInputData(
            orders:["9af0f5df-52ca-4d93-9da3-59ee5cbad865"]
        ));
        $this->assertNotEmpty($result->checkoutDetail);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioCheckoutLabelException::class);
        $this->expectExceptionCode(422);

        $checkoutLabel = new CheckoutLabel(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $checkoutLabel->confirmingPushase(new CheckoutLabelInputData(
            orders: []
        ));
    }
}
