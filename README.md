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

### Cotação do Frete

## Calculando por Produtos
```php
$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
            //isSandBox: true (Optional)
);

$freightCalculationResponse = $melhorEnvioService->freightCalculate(
    new InputData(
        new ToData(postalCode: "60820050"),
        new FromData(postalCode: "60820050"),
        products: new ProductCollection(
            [
                new Products(
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
    [deliveryDetails] => [
            [0] => [
                    [id] => 1
                    [name] => PAC
                    [error] => Serviço econômico indisponível para o trecho.
                    [company] => [
                            [id] => 1
                            [name] => Correios
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                        ]

                ]
            [1] => [
                    [id] => 2
                    [name] => SEDEX
                    [price] => 18.08
                    [custom_price] => 18.08
                    [discount] => 9.12
                    [currency] => R$
                    [delivery_time] => 2
                    [delivery_range] => [
                            [min] => 1
                            [max] => 2
                        ]
                    [custom_delivery_time] => 2
                    [custom_delivery_range] => [
                            [min] => 1
                            [max] => 2
                        ]
                    [packages] => [
                            [0] => [
                                    [price] => 18.08
                                    [discount] => 9.12
                                    [format] => box
                                    [dimensions] => [
                                            [height] => 11
                                            [width] => 11
                                            [length] => 17
                                        ]

                                    [weight] => 3.00
                                    [insurance_value] => 10.10
                                    [products] => [
                                            [0] => [
                                                    [id] => x
                                                    [quantity] => 1
                                                ]

                                        ]

                                ]

                        ]
                    [additional_services] => [
                            [receipt] => 
                            [own_hand] => 
                            [collect] => 
                        ]
                    [company] => [
                            [id] => 1
                            [name] => Correios
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                        ]

                ] 
        [...]
    ]
]
```

## Calculando por Pacote
```php
$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
            //isSandBox: true (Optional)
);

$freightCalculationResponse = $melhorEnvioService->freightCalculate(
    new InputData(
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

print_r($freightCalculationResponse);
```

Saída

```
[
    [deliveryDetails] => [
            [0] => [
                    [id] => 1
                    [name] => PAC
                    [error] => Serviço econômico indisponível para o trecho.
                    [company] => [
                            [id] => 1
                            [name] => Correios
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                        ]

                ]
            [1] => [
                    [id] => 2
                    [name] => SEDEX
                    [price] => 18.08
                    [custom_price] => 18.08
                    [discount] => 9.12
                    [currency] => R$
                    [delivery_time] => 2
                    [delivery_range] => [
                            [min] => 1
                            [max] => 2
                        ]
                    [custom_delivery_time] => 2
                    [custom_delivery_range] => [
                            [min] => 1
                            [max] => 2
                        ]
                    [packages] => [
                            [0] => [
                                    [price] => 18.08
                                    [discount] => 9.12
                                    [format] => box
                                    [dimensions] => [
                                            [height] => 11
                                            [width] => 11
                                            [length] => 17
                                        ]

                                    [weight] => 3.00
                                    [insurance_value] => 10.10
                                    [products] => [
                                            [0] => [
                                                    [id] => x
                                                    [quantity] => 1
                                                ]

                                        ]

                                ]

                        ]
                    [additional_services] => [
                            [receipt] => 
                            [own_hand] => 
                            [collect] => 
                        ]
                    [company] => [
                            [id] => 1
                            [name] => Correios
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                        ]

                ] 
        [...]
    ]
]
```

### Inserindo Fretes no Carrinho

os campos companyDocument e document se referem ao CNPJ e/ou CPF, caso a flag isDocument for habilitada 
o campo CPF será obrigatório, caso contrário o campo CNPJ será obrigatório

```php
$addShippingToCart = new AddShippingToCart(
accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
userAgent: "name project (email vinculed)",
//isSandBox: true (Optional)
);
$addShippingToCartResponse = $addShippingToCart->add(new AddShippingToCartInputData(
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
                isDocument: true
            ),
            products: new ProductCollection(
                [
                    new Products(
                    name: 'perfume'
                    )
                ]
            ),
            volumes: new VolumeCollection(
                [
                new Volumes(
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
    [id] => 9af54411-a4c1-4e64-9ccd-06959f59b984
    [protocol] => ORD-202312198407
    [serviceId] => 2
    [price] => 615.76
    [deliveryMin] => 4
    [deliveryMax] => 5
    [status] => pending
    [payloadDetails] => [
            [id] => 9af54411-a4c1-4e64-9ccd-06959f59b984
            [protocol] => ORD-202312198407
            [service_id] => 2
            [agency_id] => 
            [contract] => 
            [service_code] => 
            [quote] => 615.76
            [price] => 615.76
            [coupon] => 
            [discount] => 107.05
            [delivery_min] => 4
            [delivery_max] => 5
            [status] => pending
            [reminder] => 
            [insurance_value] => 50
            [weight] => 
            [width] => 
            [height] => 
            [length] => 
            [diameter] => 
            [format] => box
            [billed_weight] => 30.1
            [receipt] => 
            [own_hand] => 
            [collect] => 
            [collect_scheduled_at] => 
            [reverse] => 0
            [non_commercial] => 1
            [authorization_code] => 
            [tracking] => 
            [self_tracking] => 
            [delivery_receipt] => 
            [additional_info] => 
            [cte_key] => 
            [paid_at] => 
            [generated_at] => 
            [posted_at] => 
            [delivered_at] => 
            [canceled_at] => 
            [suspended_at] => 
            [expired_at] => 
            [created_at] => 2023-12-28 16:46:36
            [updated_at] => 2023-12-28 16:46:36
            [parse_pi_at] => 
            [user] => [
                    [id] => 9ad5adfb-bc45-4cce-a1a2-ec8e42b743a2
                    [protocol] => USR-2023128218
                    [firstname] => pietro
                    [lastname] => coelho
                    [email] => coelhopietro17@gmail.com
                    [picture] => 
                    [thumbnail] => 
                    [document] => 07875655390
                    [birthdate] => 2000-07-25T00:00:00.000000Z
                    [email_confirmed_at] => 2023-12-12T23:56:16.000000Z
                    [email_alternative] => 
                    [imported] => 0
                    [access_at] => 2023-12-21T16:55:26.000000Z
                    [created_at] => 2023-12-12T23:56:16.000000Z
                    [updated_at] => 2023-12-12T23:57:12.000000Z
                    [app_id] => 1
                ]
            [products] => [
                ]

            [volumes] => [
                    [0] => [
                            [id] => 203204
                            [height] => 43.00
                            [width] => 60.00
                            [length] => 70.00
                            [diameter] => 0.00
                            [weight] => 30.00
                            [format] => box
                            [created_at] => 2023-12-28 16:46:36
                            [updated_at] => 2023-12-28 16:46:36
                        ]

                ]

        ]

]
```

### Compra de Fretes

```php
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
    [purchase] =>
        [
            [id] => 9af54936-6611-4152-a4dc-8cba23127b2e
            [protocol] => PUR-20231235457
            [total] => 615.76
            [discount] => 107.05
            [status] => paid
            [paid_at] => 2023-12-28 17:00:59
            [canceled_at] => 
            [created_at] => 2023-12-28 17:00:59
            [updated_at] => 2023-12-28 17:00:59
            [payment] => 
            [transactions] =>
                [
                    [0] =>
                        [
                            [id] => 9af54936-6d78-4215-87b0-19f7581056ec
                            [protocol] => TRN-20231275008
                            [value] => 615.76
                            [type] => debit
                            [status] => authorized
                            [description] => Pagamento de envios (PUR-20231235457)
                            [authorized_at] => 2023-12-28 17:00:59
                            [unauthorized_at] => 
                            [reserved_at] => 
                            [canceled_at] => 
                            [created_at] => 2023-12-28 17:00:59
                            [description_internal] => 
                            [reason] =>
                                [
                                    [id] => 7
                                    [label] => Pagamento de envios
                                    [description] => 
                                ]
                        ]
                ]
            [orders] =>
                [
                    [0] =>
                        [
                            [id] => 9af54411-a4c1-4e64-9ccd-06959f59b984
                            [protocol] => ORD-202312198407
                            [service_id] => 2
                            [agency_id] => 
                            [contract] => 
                            [service_code] => 
                            [quote] => 615.76
                            [price] => 615.76
                            [coupon] => 
                            [discount] => 107.05
                            [delivery_min] => 4
                            [delivery_max] => 5
                            [status] => released
                            [reminder] => 
                            [insurance_value] => 50
                            [weight] => 
                            [width] => 
                            [height] => 
                            [length] => 
                            [diameter] => 
                            [format] => box
                            [billed_weight] => 30.1
                            [receipt] => 
                            [own_hand] => 
                            [collect] => 
                            [collect_scheduled_at] => 
                            [reverse] => 0
                            [non_commercial] => 1
                            [authorization_code] => 
                            [tracking] => 
                            [self_tracking] => 
                            [delivery_receipt] => 
                            [additional_info] => 
                            [cte_key] => 
                            [paid_at] => 2023-12-28 17:00:59
                            [generated_at] => 
                            [posted_at] => 
                            [delivered_at] => 
                            [canceled_at] => 
                            [suspended_at] => 
                            [expired_at] => 
                            [created_at] => 2023-12-28 16:46:36
                            [updated_at] => 2023-12-28 17:00:59
                            [parse_pi_at] => 
                            [from] =>
                                [
                                    [name] => Joana
                                    [phone] => 
                                    [email] => coelhopietro17@gmail.com
                                    [document] => 
                                    [company_document] => 93472569000130
                                    [state_register] => 
                                    [postal_code] => 8552070
                                    [address] => Conjunto Ceará
                                    [location_number] => 
                                    [complement] => 
                                    [district] => 
                                    [city] => Cidade 2000
                                    [state_abbr] => SP
                                    [country_id] => BR
                                    [latitude] => 
                                    [longitude] => 
                                    [note] => 
                                    [economic_activity_code] => 
                                ]
                            [to] =>
                                [
                                    [name] => Larissa
                                    [phone] => 
                                    [email] => 
                                    [document] => 21540911055
                                    [company_document] => 
                                    [state_register] => 
                                    [postal_code] => 60820050
                                    [address] => Jardim das Oliveiras
                                    [location_number] => 
                                    [complement] => 
                                    [district] => 
                                    [city] => Cidade 2000
                                    [state_abbr] => CE
                                    [country_id] => BR
                                    [latitude] => 
                                    [longitude] => 
                                    [note] => 
                                    [economic_activity_code] => 
                                ]
                            [service] =>
                                [
                                    [id] => 2
                                    [name] => SEDEX
                                    [status] => available
                                    [type] => express
                                    [range] => interstate
                                    [restrictions] => {"insurance_value":{"min":0,"max":10000,"max_dec":1000},"formats":{"box":{"weight":{"min":0.001,"max":30},"width":{"min":11,"max":100},"height":{"min":2,"max":100},"length":{"min":16,"max":100},"sum":200},"roll":{"weight":{"min":0.001,"max":30},"diameter":{"min":5,"max":91},"length":{"min":18,"max":100},"sum":200},"letter":{"weight":{"min":0.001,"max":0.5},"width":{"min":11,"max":60},"length":{"min":16,"max":60}}}}
                                    [requirements] => ["names","addresses","documents"]
                                    [optionals] => ["AR","MP","VD"]
                                    [company] =>
                                        [
                                            [id] => 1
                                            [name] => Correios
                                            [has_grouped_volumes] => 0
                                            [status] => available
                                            [picture] => /images/shipping-companies/correios.png
                                            [tracking_link] => https://www.melhorrastreio.com.br/rastreio/
                                            [use_own_contract] => 
                                            [batch_size] => 1
                                        ]

                                ]
                            [agency] => 
                            [invoice] => 
                            [tags] =>
                                [
                                ]
                            [products] =>
                                [
                                ]
                        ]
                ]
        ]
    [payloadDetails] =>
        [
            [purchase] =>
                [
                    [id] => 9af54936-6611-4152-a4dc-8cba23127b2e
                    [protocol] => PUR-20231235457
                    [total] => 615.76
                    [discount] => 107.05
                    [status] => paid
                    [paid_at] => 2023-12-28 17:00:59
                    [canceled_at] => 
                    [created_at] => 2023-12-28 17:00:59
                    [updated_at] => 2023-12-28 17:00:59
                    [payment] => 
                    [transactions] =>
                        [
                            [0] =>
                                [
                                    [id] => 9af54936-6d78-4215-87b0-19f7581056ec
                                    [protocol] => TRN-20231275008
                                    [value] => 615.76
                                    [type] => debit
                                    [status] => authorized
                                    [description] => Pagamento de envios (PUR-20231235457)
                                    [authorized_at] => 2023-12-28 17:00:59
                                    [unauthorized_at] => 
                                    [reserved_at] => 
                                    [canceled_at] => 
                                    [created_at] => 2023-12-28 17:00:59
                                    [description_internal] => 
                                    [reason] =>
                                        [
                                            [id] => 7
                                            [label] => Pagamento de envios
                                            [description] => 
                                        ]
                                ]
                        ]
                    [orders] =>
                        [
                            [0] =>
                                [
                                    [id] => 9af54411-a4c1-4e64-9ccd-06959f59b984
                                    [protocol] => ORD-202312198407
                                    [service_id] => 2
                                    [agency_id] => 
                                    [contract] => 
                                    [service_code] => 
                                    [quote] => 615.76
                                    [price] => 615.76
                                    [coupon] => 
                                    [discount] => 107.05
                                    [delivery_min] => 4
                                    [delivery_max] => 5
                                    [status] => released
                                    [reminder] => 
                                    [insurance_value] => 50
                                    [weight] => 
                                    [width] => 
                                    [height] => 
                                    [length] => 
                                    [diameter] => 
                                    [format] => box
                                    [billed_weight] => 30.1
                                    [receipt] => 
                                    [own_hand] => 
                                    [collect] => 
                                    [collect_scheduled_at] => 
                                    [reverse] => 0
                                    [non_commercial] => 1
                                    [authorization_code] => 
                                    [tracking] => 
                                    [self_tracking] => 
                                    [delivery_receipt] => 
                                    [additional_info] => 
                                    [cte_key] => 
                                    [paid_at] => 2023-12-28 17:00:59
                                    [generated_at] => 
                                    [posted_at] => 
                                    [delivered_at] => 
                                    [canceled_at] => 
                                    [suspended_at] => 
                                    [expired_at] => 
                                    [created_at] => 2023-12-28 16:46:36
                                    [updated_at] => 2023-12-28 17:00:59
                                    [parse_pi_at] => 
                                    [from] =>
                                        [
                                            [name] => Joana
                                            [phone] => 
                                            [email] => coelhopietro17@gmail.com
                                            [document] => 
                                            [company_document] => 93472569000130
                                            [state_register] => 
                                            [postal_code] => 8552070
                                            [address] => Conjunto Ceará
                                            [location_number] => 
                                            [complement] => 
                                            [district] => 
                                            [city] => Cidade 2000
                                            [state_abbr] => SP
                                            [country_id] => BR
                                            [latitude] => 
                                            [longitude] => 
                                            [note] => 
                                            [economic_activity_code] => 
                                        ]
                                    [to] =>
                                        [
                                            [name] => Larissa
                                            [phone] => 
                                            [email] => 
                                            [document] => 21540911055
                                            [company_document] => 
                                            [state_register] => 
                                            [postal_code] => 60820050
                                            [address] => Jardim das Oliveiras
                                            [location_number] => 
                                            [complement] => 
                                            [district] => 
                                            [city] => Cidade 2000
                                            [state_abbr] => CE
                                            [country_id] => BR
                                            [latitude] => 
                                            [longitude] => 
                                            [note] => 
                                            [economic_activity_code] => 
                                        ]
                                    [service] =>
                                        [
                                            [id] => 2
                                            [name] => SEDEX
                                            [status] => available
                                            [type] => express
                                            [range] => interstate
                                            [restrictions] => {"insurance_value":{"min":0,"max":10000,"max_dec":1000},"formats":{"box":{"weight":{"min":0.001,"max":30},"width":{"min":11,"max":100},"height":{"min":2,"max":100},"length":{"min":16,"max":100},"sum":200},"roll":{"weight":{"min":0.001,"max":30},"diameter":{"min":5,"max":91},"length":{"min":18,"max":100},"sum":200},"letter":{"weight":{"min":0.001,"max":0.5},"width":{"min":11,"max":60},"length":{"min":16,"max":60}}}}
                                            [requirements] => ["names","addresses","documents"]
                                            [optionals] => ["AR","MP","VD"]
                                            [company] =>
                                                [
                                                    [id] => 1
                                                    [name] => Correios
                                                    [has_grouped_volumes] => 0
                                                    [status] => available
                                                    [picture] => /images/shipping-companies/correios.png
                                                    [tracking_link] => https://www.melhorrastreio.com.br/rastreio/
                                                    [use_own_contract] => 
                                                    [batch_size] => 1
                                                ]

                                        ]

                                    [agency] => 
                                    [invoice] => 
                                    [tags] =>
                                        [
                                        ]

                                    [products] =>
                                        [
                                        ]
                                ]
                        ]
                ]
            [conciliation_group] =>
                [
                    [id] => 9af54936-3e51-4ee8-9e16-ff6b585a3ecc
                    [protocol] => CGP-20231211803
                    [total] => 16
                    [type] => debit
                    [status] => paid
                    [paid_at] => 2023-12-28 17:00:59
                    [canceled_at] => 
                    [created_at] => 2023-12-28 17:00:59
                    [updated_at] => 2023-12-28 17:00:59
                    [conciliations] =>
                        [
                            [0] =>
                                [
                                    [status] => paid
                                    [service_code] => 
                                    [from_postal_code] => 8552070
                                    [from_city] => Cidade dos Empregados
                                    [from_state_abbr] => SP
                                    [to_postal_code] => 60820050
                                    [to_city] => Cidade 2000
                                    [to_state_abbr] => CE
                                    [authorization_code] => 2023122801
                                    [tracking] => ME2300492W0BR
                                    [quote] => 631.76
                                    [price] => 631.76
                                    [discount] => 123.05
                                    [value] => 16
                                    [type] => debit
                                    [insurance_value] => 50
                                    [weight] => 
                                    [width] => 
                                    [height] => 
                                    [length] => 
                                    [diameter] => 
                                    [format] => box
                                    [billed_weight] => 30.1
                                    [receipt] => 
                                    [own_hand] => 
                                    [collect] => 
                                    [distinct_metrics] => 1
                                    [paid_at] => 2023-12-28 17:00:59
                                    [canceled_at] => 
                                    [created_at] => 2023-12-28 01:45:13
                                    [updated_at] => 2023-12-28 17:00:59
                                    [rate] => 
                                    [user] =>
                                        [
                                            [id] => 9ad5adfb-bc45-4cce-a1a2-ec8e42b743a2
                                            [protocol] => USR-2023128218
                                            [firstname] => pietro
                                            [lastname] => coelho
                                            [email] => coelhopietro17@gmail.com
                                            [picture] => 
                                            [thumbnail] => 
                                            [document] => 07875655390
                                            [birthdate] => 2000-07-25T00:00:00.000000Z
                                            [email_confirmed_at] => 2023-12-12T23:56:16.000000Z
                                            [email_alternative] => 
                                            [imported] => 0
                                            [access_at] => 2023-12-21T16:55:26.000000Z
                                            [created_at] => 2023-12-12T23:56:16.000000Z
                                            [updated_at] => 2023-12-12T23:57:12.000000Z
                                            [app_id] => 1
                                        ]
                                    [group] =>
                                        [
                                            [id] => 9af54936-3e51-4ee8-9e16-ff6b585a3ecc
                                            [protocol] => CGP-20231211803
                                            [total] => 16
                                            [type] => debit
                                            [status] => paid
                                            [paid_at] => 2023-12-28 17:00:59
                                            [canceled_at] => 
                                            [created_at] => 2023-12-28 17:00:59
                                            [updated_at] => 2023-12-28 17:00:59
                                        ]
                                    [agency] => 
                                ]
                        ]
                    [transactions] =>
                        [
                            [0] =>
                                [
                                    [id] => 9af54936-40ac-4015-badb-dc9442b569ec
                                    [protocol] => TRN-20231275007
                                    [value] => 16
                                    [type] => debit
                                    [status] => authorized
                                    [description] => Pagamento de pendências via conferência de postagens (CGP-20231211803]
                                    [authorized_at] => 2023-12-28 17:00:59
                                    [unauthorized_at] => 
                                    [reserved_at] => 
                                    [canceled_at] => 
                                    [created_at] => 2023-12-28 17:00:59
                                    [description_internal] => 
                                    [reason] =>
                                        [
                                            [id] => 8
                                            [label] => Pagamento de pendência via conferência de postagens
                                            [description] => 
                                        ]
                                ]
                        ]
                    [payment] => 
                ]
            [digitable] => 
            [redirect] => 
            [message] => 
            [token] => 
            [payment_id] => 
        ]
]
```

### Geração de Etiquetas

```php
$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)",
            //isSandBox: true (Optional)
);

        $generateLabelResponse = $melhorEnvioService->generateLabel(new InputData(
        orders:new OrderCollection(
            [new Order(key: "9af54411-a4c1-4e64-9ccd-06959f59b984")]
        )
    )
);

print_r($generateLabelResponse);
```
Saída

```
[
    [details] => [
            [9af54411-a4c1-4e64-9ccd-06959f59b984] => [
                    [status] => 1
                    [message] => Envio gerado com sucesso
                ]
        ]
]
```

## Contributing

Pull Request são bem-vindos. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## Licence

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.