<?php

declare(strict_types=1);

namespace FreightCalculation;

use Tests\TestCase;
use Tests\Trait\HttpClientMock;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ToData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\Package;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FromData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\Product;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\FreightCalculation;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\PackageCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ProductCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\MelhorEnvioFreightCalculationException;

final class FreightCalculationTest extends TestCase
{
    use HttpClientMock;

    public function testLookingForFreightCalculationInProduct()
    {

        $freightCalculation = new FreightCalculation(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $freightCalculation->calculate(new InputData(
            new ToData(postalCode: "60820050"),
            new FromData(postalCode: "60820050"),
            products: new ProductCollection(
                [
                    new Product(
                        id: 'x',
                        width: 11,
                        height: 17,
                        length: 11,
                        weight: 3,
                        insurance_value: 10.1,
                        quantity: 1
                    )
                ]
            )
        ));

        $this->assertNotEmpty($result->deliveryDetails);
    }

    public function testLookingForFreightCalculationInPackage()
    {

        $freightCalculation = new FreightCalculation(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $freightCalculation->calculate(new InputData(
            new ToData(postalCode: "60820050"),
            new FromData(postalCode: "60820050"),
            package: new PackageCollection(
                [
                    new Package(
                        height: 17,
                        width: 11,
                        length: 11,
                        weight: 3,
                    )
                ]
            ),
            isProduct: false
        ));
        $this->assertNotEmpty($result->deliveryDetails);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioFreightCalculationException::class);
        $this->expectExceptionCode(422);

        $freightCalculation = new FreightCalculation(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $freightCalculation->calculate(new InputData(
            new ToData(postalCode: "60820050"),
            new FromData(postalCode: "60820050"),
            products: new ProductCollection(
                [
                    new Product(
                        id: 'x',
                        width: 11,
                        height: 17,
                        length: 11,
                        weight: 3,
                        insurance_value: 10.1,
                        quantity: 1
                    )
                ]
            )
        ));
    }

    public function testItShouldThrowAnErrorWhenThePostalCodeIsEmpty()
    {
        $this->expectException(MelhorEnvioFreightCalculationException::class);
        $this->expectExceptionMessage('O campo postal code não pode ser vazio');
        $this->expectExceptionCode(400);

        $freightCalculation = new FreightCalculation(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $freightCalculation->calculate(new InputData(
            new ToData(postalCode: ""),
            new FromData(postalCode: "60820050"),
            products: new ProductCollection(
                [
                    new Product(
                        id: 'x',
                        width: 11,
                        height: 17,
                        length: 11,
                        weight: 3,
                        insurance_value: 10.1,
                        quantity: 1
                    )
                ]
            )
        ));
    }

    public function testItShouldThrowAnErrorWhenThePostalCodeIsIncorrect()
    {
        $this->expectException(MelhorEnvioFreightCalculationException::class);
        $this->expectExceptionMessage('O campo postal code só pode conter numeros');
        $this->expectExceptionCode(400);

        $freightCalculation = new FreightCalculation(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $freightCalculation->calculate(new InputData(
            new ToData(postalCode: "dlaksml"),
            new FromData(postalCode: "60820050"),
            products: new ProductCollection(
                [
                    new Product(
                        id: 'x',
                        width: 11,
                        height: 17,
                        length: 11,
                        weight: 3,
                        insurance_value: 10.1,
                        quantity: 1
                    )
                ]
            )
        ));
    }
}
