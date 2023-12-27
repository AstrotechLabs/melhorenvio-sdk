<?php

declare(strict_types=1);

namespace Tests\Integration\FreightCalculation;

use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FreightCalculationInputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\FreightCalculation;
use AstrotechLabs\MelhorEnvio\FreightCalculation\MelhorEnvioFreightCalculationException;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;

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

        $result = $freightCalculation->calculate(new FreightCalculationInputData(
            to:"60820050",
            from: "60442-611",
            extra: [
                "products" => [
                    [
                        "id" => self::$faker->uuid(),
                        "width" => self::$faker->randomFloat(),
                        "height" => self::$faker->randomFloat(),
                        "length" => self::$faker->randomFloat(),
                        "weight" => self::$faker->randomFloat(),
                        "insurance_value" => self::$faker->randomFloat(),
                        "quantity" => self::$faker->buildingNumber
                    ]
                ],
                "options" => [
                    "insurance_value" => 1180.87,
                    "receipt" => false,
                    "own_hand" => false
                ],
                "services" => "1,2,3"
            ]
        ));

        $this->assertNotEmpty($result->deliveryDetail);
    }

    public function testLookingForFreightCalculationInPackage()
    {

        $freightCalculation = new FreightCalculation(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $freightCalculation->calculate(new FreightCalculationInputData(
            to:"60820050",
            from: "60442-611",
            extra: [
                "package" => [
                    "height" => 4,
                    "width" => 12,
                    "length" => 17,
                    "weight" => 0.3
                ],
                "options" => [
                    "insurance_value" => 1180.87,
                    "receipt" => false,
                    "own_hand" => false
                ],
                "services" => "1,2,3"
            ]
        ));
        $this->assertNotEmpty($result->deliveryDetail);
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

        $freightCalculation->calculate(new FreightCalculationInputData(
            to:"",
            from: "",
            extra: [
                "products" => [
                    [
                "id" => self::$faker->uuid(),
                "width" => self::$faker->randomFloat(),
                "height" => self::$faker->randomFloat(),
                "length" => self::$faker->randomFloat(),
                "weight" => self::$faker->randomFloat(),
                "insurance_value" => self::$faker->randomFloat(),
                "quantity" => self::$faker->buildingNumber
                    ]
                ]
            ]
        ));
    }
}
