<?php

declare(strict_types=1);

namespace Integration\AddShippingToCart;

use AstrotechLabs\MelhorEnvio\AddShippingToCart\AddShippingToCart;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartInputData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\MelhorEnvioAddShippingToCartException;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;

final class AddShippingToCartTest extends TestCase
{
    use HttpClientMock;

    public function testLookingForShippingInformation()
    {
        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $result = $addShippingToCart->adding(new AddShippingToCartInputData(
            service: 2,
            from: [
                "name" => self::$faker->name(),
                "company_document" => self::$faker->cnpj(),
                "address" => self::$faker->streetAddress,
                "number" => self::$faker->buildingNumber,
                "city" => self::$faker->city,
                "postal_code" => self::$faker->postcode,
            ],
            to:[
                "name" => self::$faker->name(),
                "company_document" => self::$faker->cnpj(),
                "address" => self::$faker->streetAddress,
                "number" => self::$faker->buildingNumber,
                "city" => self::$faker->city,
                "postal_code" => self::$faker->postcode,
            ],
            products: [
                ["name" => self::$faker->name()],
                ["name" => self::$faker->name()],
            ],
            volumes:[
                [
                "height" => 43,
                "width" => 60,
                "length" => 70,
                "weight" => 30
                ]
            ],
            options:[
                "insurance_value" => 50.00,
                "receipt" => false,
                "own_hand" => false,
                "reverse" => false,
                "non_commercial" => true
            ]
        ));

        $this->assertNotEmpty($result->itemDetails);
    }

    public function testItShouldThrowAnErrorWhenResponseReturnsAnyError()
    {
        $this->expectException(MelhorEnvioAddShippingToCartException::class);
        $this->expectExceptionCode(422);

        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $addShippingToCart->adding(new AddShippingToCartInputData(
            service: 1,
            from: [
                "address" => self::$faker->streetAddress,
                "number" => self::$faker->buildingNumber,
                "city" => self::$faker->city,
                "postal_code" => self::$faker->postcode,
            ],
            to:[
                "name" => self::$faker->name(),
                "company_document" => self::$faker->cnpj(),
                "address" => self::$faker->streetAddress,
                "number" => self::$faker->buildingNumber,
                "city" => self::$faker->city,
                "postal_code" => self::$faker->postcode,
            ],
            products: [
                ["name" => self::$faker->name()],
                ["name" => self::$faker->name()],
            ],
            volumes:[
                "height" => 43,
                "width" => 60,
                "length" => 70,
                "weight" => 30
            ],
            options:[
                "insurance_value" => 50.00,
                "receipt" => false,
                "own_hand" => false,
                "reverse" => false,
                "non_commercial" => true
            ]
        ));
    }
}
