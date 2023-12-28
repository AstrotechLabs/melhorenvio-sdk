<?php

use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\OptionsData as AddShippingToCartOptionData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Product as AddShippingToCartProduct;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ProductCollection as AddShippingToCartProductCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ToData as AddShippingToCartToData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Volume as AddShippingToCartVolume;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\VolumeCollection as AddShippingToCartVolumeCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartItem;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\FromData as AddShippingToCartFromData;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\InputData as CheckoutLabelInput;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\Order as CheckoutLabelOrder;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\OrderCollection as CheckoutLabelOrderCollection;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\InputData as GenerateLabelInputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\Order as GenerateLabelOrder;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\OrderCollection as GenerateLabelOrderCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FromData as FreightCalculationFromData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData as FreightCalculationInputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\Product as FreightCalculationProduct;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ProductCollection as FreightCalculationProductCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ToData as FreightCalculationToData;
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;

$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
    isSandBox: true
);

/**
 Aqui executamos a ação de calcular o frete.
 */

$melhorEnvioService->freightCalculate(
    new FreightCalculationInputData(
        to: new FreightCalculationToData(postalCode: "60820050"),
        from: new FreightCalculationFromData(postalCode: "60820050"),
        products: new FreightCalculationProductCollection(
            [
                new FreightCalculationProduct(
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
    )
);

/**
Iniciando o fluxo de adição do pedido no carrinho, compra de frete e geração da etiqueta
 */

$addShippingToCartResponse = $melhorEnvioService->addShippingToCart(new AddShippingToCartItem(
    service: 2,
    from: new AddShippingToCartFromData(
        name: self::$faker->name(),
        companyDocument: "93.472.569/0001-30",
        address: "Jardim sem Oliveiras",
        city: "Cidade dos Empregados",
        postalCode:"08552070"
    ),
    to: new AddShippingToCartToData(
        name: self::$faker->name(),
        document: "21540911055",
        address: "Jardim das Oliveiras",
        city: "Cidade 2000",
        postalCode:"60820050",
        isPf: true
    ),
    products: new AddShippingToCartProductCollection(
        [
            new AddShippingToCartProduct(
                name: 'perfume'
            )
        ]
    ),
    volumes: new AddShippingToCartVolumeCollection(
        [
            new AddShippingToCartVolume(
                height: 43,
                width: 60,
                length: 70,
                weight: 30
            )
        ]
    ),
    options:new AddShippingToCartOptionData(
        insuranceValue: 50.00,
    )
));


$checkoutLabelResponse = $melhorEnvioService->checkoutLabel(
    new CheckoutLabelInput(
        orders: new CheckoutLabelOrderCollection(
            [
                new CheckoutLabelOrder(
                    key: $addShippingToCartResponse['id']
                )
            ]
        )
    )
);

$generateLabelResponse = $melhorEnvioService->generateLabel(new GenerateLabelInputData(
    orders: new GenerateLabelOrderCollection(
        [
                new GenerateLabelOrder(
                    key: $addShippingToCartResponse['id']
                )
            ]
    )
));
