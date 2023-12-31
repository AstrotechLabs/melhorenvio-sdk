<?php

declare(strict_types=1);

namespace Tests\Integration\FreightCalculation;

use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ToData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\Package;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\Product;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FromData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\PackageCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ProductCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\MelhorEnvioFreightCalculationException;

final class FreightCalculationTest extends TestCase
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
    public function testLookingForFreightCalculationInProduct()
    {
        $result = $this->service->freightCalculate(new InputData(
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

        $this->assertNotEmpty($result['deliveryDetails']);
    }

    public function testLookingForFreightCalculationInPackages()
    {
        $result = $this->service->freightCalculate(new InputData(
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
        $this->assertNotEmpty($result['deliveryDetails']);
    }

    public function testLookingForFreightCalculationWithMultiplePackages()
    {
        $result = $this->service->freightCalculate(new InputData(
            new ToData(postalCode: "60820050"),
            new FromData(postalCode: "60820050"),
            package: new PackageCollection(
                [
                    new Package(
                        height: 17,
                        width: 11,
                        length: 11,
                        weight: 3,
                    ),
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
        $this->assertNotEmpty($result['deliveryDetails']);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioFreightCalculationException::class);
        $this->expectExceptionCode(422);

        $this->service->freightCalculate(new InputData(
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

        $this->service->freightCalculate(new InputData(
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

        $this->service->freightCalculate(new InputData(
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
