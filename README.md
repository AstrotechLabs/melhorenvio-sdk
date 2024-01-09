# Melhor Envio SDK para PHP

Bem-vindo ao SDK do Melhor Envio!
Nossa biblioteca permite ao desenvolvedor realizar uma comunicação simples e direta com o serviço Melhor Envio.
Com ela é possível realizar operações como fazer cotação de frete, criação de pedidos, 
compra de frete e geração de etiquetas (veja exemplos). 


## Índice

  - [Instalação](#instalação)
  - [Como Usar?](#como-usar)
  - [Cotações de Frete](#cotações-de-frete)
    - [Por Produtos](#por-produtos)
    - [Por Pacotes](#por-pacotes)
    - [Inserção de itens ao carrinho](#inserção-de-itens-ao-carrinho)
    - [Compra de Fretes](#compra-de-fretes)
    - [Geração de Etiquetas](#geração-de-etiquetas)
  - [Exemplo de uso](#abaixo-veja-o-exemplo-do-fluxo-desde-a-cotação-do-frete-à-geração-de-etiquetas)
  - [Contributing](#contributing)
  - [Licence](#licence)

## Instalação

A forma mais recomendada de instalar este pacote é através do [composer](http://getcomposer.org/download/).

Para instalar, basta executar o comando abaixo

```bash
@todo
```

ou adicionar esse linha

```
@todo
```

na seção `require` do seu arquivo `composer.json`.

## Como Usar?
## Cotações de Frete

Em nosso SDK é permitido realizar as cotações tanto por produtos, quanto por pacotes.

### Por Produtos
É possível realizar o cálculo de um frete por produtos individualmente, informando o peso e os demais dados abaixo.
```php
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ToData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FromData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ProductCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\Product;

$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)", // esse nome e email são os dados que foram cadastrados no melhor envio
    //isSandBox: true (Optional)
);

$freightCalculationResponse = $melhorEnvioService->freightCalculate(
    new InputData(
        to: new ToData(postalCode: "60820050"),
        from: new FromData(postalCode: "60820050"),
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
    )
);

print_r($freightCalculationResponse);
```
Saída

```
[
    'deliveryDetails' => [
            [
              'id' => 1
              'name' => PAC
              'error' => Serviço econômico indisponível para o trecho.
              'company' => [
                      'id' => 1
                      'name' => Correios
                      'picture' => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                  ]
                ],
             [
                'id' => 2
                'name' => SEDEX
                'price' => 18.08
                'custom_price' => 18.08
                'discount' => 9.12
                'currency' => R$
                'delivery_time' => 2
                'delivery_range' => [
                        'min' => 1
                        'max' => 2
                    ]
                'custom_delivery_time' => 2
                'custom_delivery_range' => [
                        'min' => 1
                        'max' => 2
                    ]
                'packages' => [
                      [
                        'price' => 18.08
                        'discount' => 9.12
                        'format' => box
                        'dimensions' => [
                                'height' => 11
                                'width' => 11
                                'length' => 17
                            ]
                        'weight' => 3.00
                        'insurance_value' => 10.10
                        'products' => [
                                [
                                  'id' => x
                                  'quantity' => 1
                                ]
                            ]
                     ]
                  ],
                'additional_services' => [
                        'receipt' => 
                        'own_hand' => 
                        'collect' => 
                    ]
                'company' => [
                      'id' => 1
                      'name' => Correios
                      'picture' => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                    ]
                ]
            ...... 
    ]
]
```

### Por Pacotes
É possível realizar o cálculo por pacotes, seguindo o modelo abaixo:

```php
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\ToData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FromData;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\PackageCollection;
use AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\Package;

$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
    //isSandBox: true (Optional)
);

$freightCalculationResponse = $melhorEnvioService->freightCalculate(
    new InputData(
        to: new ToData(postalCode: "60876590"),
        from: new FromData(postalCode: "60820050"),
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
    )
);

print_r($freightCalculationResponse);
```

Saída

```
[
    'deliveryDetails' => [
            [
              'id' => 1
              'name' => PAC
              'error' => Serviço econômico indisponível para o trecho.
              'company' => [
                      'id' => 1
                      'name' => Correios
                      'picture' => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                  ]
                ],
             [
                'id' => 2
                'name' => SEDEX
                'price' => 18.08
                'custom_price' => 18.08
                'discount' => 9.12
                'currency' => R$
                'delivery_time' => 2
                'delivery_range' => [
                        'min' => 1
                        'max' => 2
                    ]
                'custom_delivery_time' => 2
                'custom_delivery_range' => [
                        'min' => 1
                        'max' => 2
                    ]
                'packages' => [
                      [
                        'price' => 18.08
                        'discount' => 9.12
                        'format' => box
                        'dimensions' => [
                                'height' => 11
                                'width' => 11
                                'length' => 17
                            ]
                        'weight' => 3.00
                        'insurance_value' => 10.10
                        'products' => [
                                [
                                  'id' => x
                                  'quantity' => 1
                                ]
                            ]
                     ]
                  ],
                'additional_services' => [
                        'receipt' => 
                        'own_hand' => 
                        'collect' => 
                    ]
                'company' => [
                      'id' => 1
                      'name' => Correios
                      'picture' => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                    ]
                ]
            ...... 
    ]
]
```

### Inserção de itens ao carrinho

Nosso SDK permite aos usuários reunir e organizar os produtos a serem enviados em um único local. 

É possível adicionar itens ao carrinho detalhando informações como peso, dimensões e valor declarado.

Antes de prosseguir, você deverá adicionar num carrinho os produtos que serão enviados. Nesse passo será gerado o pedido com todos os detalhes e será retornado um id, 
que será necessário posteriormente para a compra de frete e geração de etiqueta.

```php
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartItem;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ToData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\FromData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ProductCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Products;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\VolumeCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Volume;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\OptionsData;

$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
    //isSandBox: true (Optional)
);

$addShippingToCartResponse = $melhorEnvioService->addShippingToCart(new AddShippingToCartItem(
        service: 2,
        from: new FromData(
            name: self::$faker->name(),
            companyDocument: "93.472.569/0001-30",
            address: "Jardim sem Oliveiras",
            city: "Cidade dos Empregados",
            postalCode:"08552070" // Considera-se apenas números.
        ),
        to: new ToData(
            name: self::$faker->name(),
            document: "21540911055",
            address: "Jardim das Oliveiras",
            city: "Cidade 2000",
            postalCode:"60820050",
            isPf: true // Caso verdadeiro deverá ser informado para o atributo document um CPF válido, caso contrário será considerado um CNPJ válido
        ),
        products: new ProductCollection(
            [
                new Product(
                    name: 'perfume'
                )
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
    )
);

print_r($addShippingToCartResponse);
```

Saída

```
[
    'id' => 9af54411-a4c1-4e64-9ccd-06959f59b984
    'protocol' => ORD-202312198407
    'serviceId' => 2
    'price' => 615.76
    'deliveryMinDays' => 4
    'deliveryMaxDays' => 5
    'status' => pending
    'payloadDetails' => [
            'id' => 9af54411-a4c1-4e64-9ccd-06959f59b984
            'protocol' => ORD-202312198407
            'service_id' => 2
            'agency_id' => 
            
        ]
]
```

### Compra de Fretes
Após selecionar a melhor opção de frete com base nas cotações disponíveis,
é possível realizar a compra direta dos serviços de transporte de transportadoras parceiras. 

Para esta ação é necessário o id do pedido.

```php
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto\InputData;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto\OrderCollection;
use AstrotechLabs\MelhorEnvio\ConfirmPurchaseLabel\Dto\Order;

$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
    //isSandBox: true (Optional)
);

$confirmPurchaseLabelResponse = $melhorEnvioService->confirmPurchase(
    new InputData(
        orders: new OrderCollection(
            [
                new Order(
                    key: '9af3f99a-301e-4239-9c3d-7cb7e7bb3825'
                )
            ]
        )
    )
);

print_r($confirmPurchaseLabelResponse);
```
Saída

```
[
    'purchase' =>
    [
        'id' => 9af54936-6611-4152-a4dc-8cba23127b2e
        'protocol' => PUR-20231235457
        'total' => 615.76
        'discount' => 107.05
        'status' => paid
        'paid_at' => 2023-12-28 17:00:59
        'canceled_at' => 
        'created_at' => 2023-12-28 17:00:59
        'updated_at' => 2023-12-28 17:00:59
        'payment' => 
            'transactions' =>
                [
                    [
                    'id' => 9af54936-6d78-4215-87b0-19f7581056ec
                    'protocol' => TRN-20231275008
                    'value' => 615.76
                    'type' => debit
                    'status' => authorized
                    'description' => Pagamento de envios (PUR-20231235457)
                    'authorized_at' => 2023-12-28 17:00:59
                    'unauthorized_at' => 
                    'reserved_at' => 
                    'canceled_at' => 
                    'created_at' => 2023-12-28 17:00:59
                    'description_internal' => 
                    'reason' => [
                                'id' => 7
                                'label' => Pagamento de envios
                                'description' => 
                            ]
                    ]
                ]
            ......
        ]
'payloadDetails' =>
    [
        'purchase' => [
                'id' => 9af54936-6611-4152-a4dc-8cba23127b2e
                'protocol' => PUR-20231235457
                'total' => 615.76
                'discount' => 107.05
                'status' => paid
                'paid_at' => 2023-12-28 17:00:59
                'canceled_at' => 
                'created_at' => 2023-12-28 17:00:59
                'updated_at' => 2023-12-28 17:00:59
                'payment' => 
                'transactions' => [
                                   [
                                    'id' => 9af54936-6d78-4215-87b0-19f7581056ec
                                    'protocol' => TRN-20231275008
                                    'value' => 615.76
                                    'type' => debit
                                    'status' => authorized
                                    'description' => Pagamento de envios (PUR-20231235457)
                                    'authorized_at' => 2023-12-28 17:00:59
                                    'unauthorized_at' => 
                                    'reserved_at' => 
                                    'canceled_at' => 
                                    'created_at' => 2023-12-28 17:00:59
                                    'description_internal' => 
                                    'reason' => [
                                                    'id' => 7
                                                    'label' => Pagamento de envios
                                                    'description' => 
                                                ]
                                    ]
                                   ]
                     ]
    ]
]
```

### Geração de Etiquetas
Após a escolha da opção de frete desejada e a compra do serviço, nosso SDK possibilita a criação rápida e simples de etiquetas de envio.

Para realizar essa ação será necessário o id do pedido.

```php
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\InputData;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\OrderCollection;
use AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\Order;

$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
    //isSandBox: true (Optional)
);

$generateLabelResponse = $melhorEnvioService->generateLabel(new InputData(
        orders: new OrderCollection(
            [
                new Order(
                    key: '9af3f99a-301e-4239-9c3d-7cb7e7bb3825'
                )
            ]
        )
    )
);

print_r($generateLabelResponse);
```
Saída

```
[
    'details' => [
            '9af54411-a4c1-4e64-9ccd-06959f59b984' => [
                    'status' => 1
                    'message' => Envio gerado com sucesso
                ]
        ]
]
```

## Abaixo veja o exemplo do fluxo desde a cotação do frete à geração de etiquetas

```php
<?php
// imports aqui

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

/**
 Compra de frete
 */

$confirmPurchaseLabelResponse = $melhorEnvioService->confirmPurchase(
    new ConfirmPurchaseLabelInput(
        orders: new ConfirmPurchaseLabelOrderCollection(
            [
                new ConfirmPurchaseLabelOrder(
                    key: $addShippingToCartResponse['id']
                )
            ]
        )
    )
);

/**
 Geração da etiqueta
 */

$generateLabelResponse = $melhorEnvioService->generateLabel(new GenerateLabelInputData(
    orders: new GenerateLabelOrderCollection(
        [
                new GenerateLabelOrder(
                    key: $addShippingToCartResponse['id']
                )
            ]
    )
));

```

## Contributing

Pull Request são bem-vindos. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## License

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.