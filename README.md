# Melhor Envio SDK para PHP

Este é um repositório que possui uma abstração a API do Melhor Envio, facilitando a COTAÇÃO DE FRETE e ADIÇÃO DE PEDIDOS


## Instalação

A forma mais recomendada de instalar este pacote é através do [composer](http://getcomposer.org/download/).

Para instalar, basta executar o comando abaixo

```bash
$ php composer.phar require vaironaegos/melhorenvio-sdk
```

ou adicionar esse linha

```
"astrotechlabs/melhorenvio-sdk": "^1.0"
```

na seção `require` do seu arquivo `composer.json`.

## Como Usar?

## Cotação do Frete 
### Por Produtos
- É possível realizar o cálculo de um frete por produtos individualmente, informando o peso e os demais dados abaixo
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
- É possível realizar o cálculo por pacotes adicionando a o campo isProduct como false

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
        new ToData(postalCode: "60876590"),
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

- Antes de prosseguir, você deverá inserir á um carrinho de compras os produtos que serão enviados.
  
```php
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\InputData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ToData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\FromData;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\ProductCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Products;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\VolumeCollection;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\Volume;
use AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\OptionsData;

$addShippingToCart = new AddShippingToCart(
  accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
  userAgent: "name project (email vinculed)",
  //isSandBox: true (Optional)
);
$addShippingToCartResponse = $addShippingToCart->add(new InputData(
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
    ));

print_r($addShippingToCartResponse);
```

Saída

```
[
    'id' => 9af54411-a4c1-4e64-9ccd-06959f59b984
    'protocol' => ORD-202312198407
    'serviceId' => 2
    'price' => 615.76
    'deliveryMin' => 4
    'deliveryMax' => 5
    'status' => pending
    'payloadDetails' => [
            'id' => 9af54411-a4c1-4e64-9ccd-06959f59b984
            'protocol' => ORD-202312198407
            'service_id' => 2
            'agency_id' => 
            .......
        ]
]
```

### Compra de Fretes
- Depois de inserido o pedido no carrinho, será necessário realizar a compra do frete.
- Para esta ação é requisitado o id do pedido, à partir dessa informação será possivel realizar a compra.

```php
use AstrotechLabs\MelhorEnvio\MelhorEnvioService;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\InputData;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\OrderCollection;
use AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\Order;

$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
    //isSandBox: true (Optional)
);

$checkoutLabelResponse = $melhorEnvioService->checkoutLabel(
    new InputData(
        orders: new OrderCollection(
            [new Order(
                key: '9af3f99a-301e-4239-9c3d-7cb7e7bb3825'
            )
            ]
        )
    ));

print_r($checkoutLabelResponse);
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
                            'reason' =>
                                        [
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

- Feita compra do seu frete, será possivel gerar a etiqueta, utilizando o mesmo id do pedido.

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
        orders:new OrderCollection(
            [new Order(
            key: "9af54411-a4c1-4e64-9ccd-06959f59b984"
            )]
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

## Contributing

Pull Request são bem-vindos. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## Licence

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.