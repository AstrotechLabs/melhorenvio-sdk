<?php

declare(strict_types=1);

namespace Integration\AddShippingToCart;

use Tests\TestCase;
use Tests\Trait\HttpClientMock;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ToData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Volume;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Product;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\FromData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartItem;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\OptionsData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\AddShippingToCart;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\VolumeCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ProductCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\MelhorEnvioAddShippingToCartException;

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

        $result = $addShippingToCart->add(new AddShippingToCartItem(
            service: 2,
            from: new FromData(
                name: self::$faker->name(),
                companyDocument: "93.472.569/0001-30",
                address: "Jardim sem Oliveiras",
                city: "Cidade dos Empregados",
                postalCode:"08552070"
            ),
            to: new ToData(
                name: self::$faker->name(),
                document: "21540911055",
                address: "Jardim das Oliveiras",
                city: "Cidade 2000",
                postalCode:"60820050",
                isPf: true
            ),
            products: new ProductCollection(
                [
                    new Product(name: 'perfume')
                ]
            ),
            volumes: new VolumeCollection(
                [
                new Volume(
                    height: 43,
                    width: 60,
                    length: 70,
                    weight: 30
                )
                ]
            ),
            options:new OptionsData(
                insuranceValue: 50.00,
            )
        ));

        $this->assertNotEmpty($result->id);
        $this->assertNotEmpty($result->protocol);
        $this->assertNotEmpty($result->serviceId);
        $this->assertNotEmpty($result->price);
        $this->assertNotEmpty($result->deliveryMax);
        $this->assertNotEmpty($result->deliveryMin);
        $this->assertNotEmpty($result->status);
    }

    public function testShouldGenerateAnErrorWhenTheCnpjIsEmpty()
    {
        $this->expectException(MelhorEnvioAddShippingToCartException::class);
        $this->expectExceptionMessage('O campo CNPJ deve ser preenchido');
        $this->expectExceptionCode(400);

        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $addShippingToCart->add(new AddShippingToCartItem(
            service: 2,
            from: new FromData(
                name: self::$faker->name(),
                companyDocument: "",
                address: "Jardim sem Oliveiras",
                number: "60",
                city: "Cidade dos Empregados",
                postalCode:"08552-070"
            ),
            to: new ToData(
                name: self::$faker->name(),
                document: "21540911055",
                address: "Jardim das Oliveiras",
                number: "65",
                city: "Cidade dosFuncionários",
                postalCode:"60820-050",
                isPf: true
            ),
            products: new ProductCollection(
                [
                    new Product(name: 'perfume')
                ]
            ),
            volumes: new VolumeCollection(
                [
                    new Volume(
                        height: 43,
                        width: 60,
                        length: 70,
                        weight: 30
                    )
                ]
            ),
            options:new OptionsData(
                insuranceValue: 50.00,
            )
        ));
    }

    public function testShouldGenerateAnErrorWhenTheCpfIsEmpty()
    {
        $this->expectException(MelhorEnvioAddShippingToCartException::class);
        $this->expectExceptionMessage('O campo CPF deve ser preenchido');
        $this->expectExceptionCode(400);

        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $addShippingToCart->add(new AddShippingToCartItem(
            service: 2,
            from: new FromData(
                name: self::$faker->name(),
                companyDocument: "93.472.569/0001-30",
                address: "Jardim sem Oliveiras",
                number: "60",
                city: "Cidade dos Empregados",
                postalCode:"08552-070"
            ),
            to: new ToData(
                name: self::$faker->name(),
                document: "21540911055",
                address: "Jardim das Oliveiras",
                number: "65",
                city: "Cidade dosFuncionários",
                postalCode:"60820-050",
                isPf: true
            ),
            products: new ProductCollection(
                [
                    new Product(name: 'perfume')
                ]
            ),
            volumes: new VolumeCollection(
                [
                    new Volume(
                        height: 43,
                        width: 60,
                        length: 70,
                        weight: 30
                    )
                ]
            ),
            options:new OptionsData(
                insuranceValue: 50.00,
            )
        ));
    }

    public function testShouldGenerateAnErrorWhenTheAddressIsEmpty()
    {
        $this->expectException(MelhorEnvioAddShippingToCartException::class);
        $this->expectExceptionMessage('O campo to.address é obrigatório.');
        $this->expectExceptionCode(422);

        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $addShippingToCart->add(new AddShippingToCartItem(
            service: 2,
            from: new FromData(
                name: self::$faker->name(),
                companyDocument: "93.472.569/0001-30",
                address: "Jardim sem Oliveiras",
                number: "60",
                city: "Cidade dos Empregados",
                postalCode:"08552-070"
            ),
            to: new ToData(
                name: self::$faker->name(),
                document: "21540911055",
                address: "",
                number: "65",
                city: "Cidade dosFuncionários",
                postalCode:"60820-050",
                isPf: true
            ),
            products: new ProductCollection(
                [
                    new Product(name: 'perfume')
                ]
            ),
            volumes: new VolumeCollection(
                [
                    new Volume(
                        height: 43,
                        width: 60,
                        length: 70,
                        weight: 30
                    )
                ]
            ),
            options:new OptionsData(
                insuranceValue: 50.00,
            )
        ));
    }

    public function testShouldGenerateAnErrorWhenTheCityIsEmpty()
    {
        $this->expectException(MelhorEnvioAddShippingToCartException::class);
        $this->expectExceptionMessage('O campo to.city é obrigatório.');
        $this->expectExceptionCode(422);

        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $addShippingToCart->add(new AddShippingToCartItem(
            service: 2,
            from: new FromData(
                name: self::$faker->name(),
                companyDocument: "93.472.569/0001-30",
                address: "Jardim sem Oliveiras",
                city: "Cidade dos Empregados",
                postalCode:"08552-070"
            ),
            to: new ToData(
                name: self::$faker->name(),
                document: "21540911055",
                address: "Luiza Távora",
                city: "",
                postalCode:"60820-050",
                isPf: true
            ),
            products: new ProductCollection(
                [
                    new Product(name: 'perfume')
                ]
            ),
            volumes: new VolumeCollection(
                [
                    new Volume(
                        height: 43,
                        width: 60,
                        length: 70,
                        weight: 30
                    )
                ]
            ),
            options:new OptionsData(
                insuranceValue: 50.00,
            )
        ));
    }

    public function testShouldGenerateAnErrorWhenThePostalCodeIsEmpty()
    {
        $this->expectException(MelhorEnvioAddShippingToCartException::class);
        $this->expectExceptionMessage('O campo from.postal code é obrigatório.');
        $this->expectExceptionCode(422);

        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $addShippingToCart->add(new AddShippingToCartItem(
            service: 2,
            from: new FromData(
                name: self::$faker->name(),
                companyDocument: "93.472.569/0001-30",
                address: "Jardim sem Oliveiras",
                city: "Cidade dos Empregados",
                postalCode:""
            ),
            to: new ToData(
                name: self::$faker->name(),
                document: "21540911055",
                address: "Luiza Távora",
                city: "Cidade 2000",
                postalCode:"60820050",
                isPf: true
            ),
            products: new ProductCollection(
                [
                    new Product(name: 'perfume')
                ]
            ),
            volumes: new VolumeCollection(
                [
                    new Volume(
                        height: 43,
                        width: 60,
                        length: 70,
                        weight: 30
                    )
                ]
            ),
            options:new OptionsData(
                insuranceValue: 50.00,
            )
        ));
    }

    public function testShouldGenerateAnErrorWhenThePostalCodeIsInvalid()
    {
        $this->expectException(MelhorEnvioAddShippingToCartException::class);
        $this->expectExceptionMessage('O campo postal code só pode conter numeros');
        $this->expectExceptionCode(400);

        $addShippingToCart = new AddShippingToCart(
            accessToken: $_ENV['MELHOR_ENVIO_API_TOKEN'],
            userAgent: $_ENV['MELHOR_ENVIO_USER_AGENT'],
            isSandbox: true
        );

        $addShippingToCart->add(new AddShippingToCartItem(
            service: 2,
            from: new FromData(
                name: self::$faker->name(),
                companyDocument: "93.472.569/0001-30",
                address: "Jardim sem Oliveiras",
                city: "Cidade dos Empregados",
                postalCode:"alksmd"
            ),
            to: new ToData(
                name: self::$faker->name(),
                document: "21540911055",
                address: "Luiza Távora",
                city: "Cidade 2000",
                postalCode:"60820050",
                isPf: true
            ),
            products: new ProductCollection(
                [
                    new Product(name: 'perfume')
                ]
            ),
            volumes: new VolumeCollection(
                [
                    new Volume(
                        height: 43,
                        width: 60,
                        length: 70,
                        weight: 30
                    )
                ]
            ),
            options:new OptionsData(
                insuranceValue: 50.00,
            )
        ));
    }
}
