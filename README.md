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
$freightCalculation = new FreightCalculation(
accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
userAgent: "name project (email vinculed)",
//isSandBox: true (Optional)
);

$freightCalculationResponse = $freightCalculation->calculate(new FreightCalculationInputData(
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

## Calculando por Pacote
```php
$freightCalculation = new FreightCalculation(
accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
userAgent: "name project (email vinculed)",
//isSandBox: true (Optional)
);

$freightCalculationResponse = $freightCalculation->calculate(new FreightCalculationInputData(
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
AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\FreightCalculationOutputData Object
(
    [deliveryDetail] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [name] => PAC
                    [error] => Serviço econômico indisponível para o trecho.
                    [company] => Array
                        (
                            [id] => 1
                            [name] => Correios
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                        )
    
                )
    
            [1] => Array
                (
                    [id] => 2
                    [name] => SEDEX
                    [price] => 18.08
                    [custom_price] => 18.08
                    [discount] => 9.12
                    [currency] => R$
                    [delivery_time] => 2
                    [delivery_range] => Array
                        (
                            [min] => 1
                            [max] => 2
                        )
    
                    [custom_delivery_time] => 2
                    [custom_delivery_range] => Array
                        (
                            [min] => 1
                            [max] => 2
                        )
    
                    [packages] => Array
                        (
                            [0] => Array
                                (
                                    [price] => 18.08
                                    [discount] => 9.12
                                    [format] => box
                                    [dimensions] => Array
                                        (
                                            [height] => 11
                                            [width] => 11
                                            [length] => 17
                                        )
    
                                    [weight] => 3.00
                                    [insurance_value] => 10.10
                                    [products] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => x
                                                    [quantity] => 1
                                                )
    
                                        )
    
                                )
    
                        )
    
                    [additional_services] => Array
                        (
                            [receipt] => 
                            [own_hand] => 
                            [collect] => 
                        )
    
                    [company] => Array
                        (
                            [id] => 1
                            [name] => Correios
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                        )
    
                )
    
            [2] => Array
                (
                    [id] => 3
                    [name] => .Package
                    [price] => 22.61
                    [custom_price] => 22.61
                    [discount] => 0.00
                    [currency] => R$
                    [delivery_time] => 5
                    [delivery_range] => Array
                        (
                            [min] => 4
                            [max] => 5
                        )
    
                    [custom_delivery_time] => 5
                    [custom_delivery_range] => Array
                        (
                            [min] => 4
                            [max] => 5
                        )
    
                    [packages] => Array
                        (
                            [0] => Array
                                (
                                    [format] => box
                                    [dimensions] => Array
                                        (
                                            [height] => 11
                                            [width] => 11
                                            [length] => 17
                                        )
    
                                    [weight] => 3.00
                                    [insurance_value] => 10.10
                                    [products] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => x
                                                    [quantity] => 1
                                                )
    
                                        )
    
                                )
    
                        )
    
                    [additional_services] => Array
                        (
                            [receipt] => 
                            [own_hand] => 
                            [collect] => 
                        )
    
                    [company] => Array
                        (
                            [id] => 2
                            [name] => Jadlog
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/jadlog.png
                        )
    
                )
    
            [3] => Array
                (
                    [id] => 4
                    [name] => .Com
                    [price] => 31.28
                    [custom_price] => 31.28
                    [discount] => 0.00
                    [currency] => R$
                    [delivery_time] => 4
                    [delivery_range] => Array
                        (
                            [min] => 3
                            [max] => 4
                        )
    
                    [custom_delivery_time] => 4
                    [custom_delivery_range] => Array
                        (
                            [min] => 3
                            [max] => 4
                        )
    
                    [packages] => Array
                        (
                            [0] => Array
                                (
                                    [format] => box
                                    [dimensions] => Array
                                        (
                                            [height] => 11
                                            [width] => 11
                                            [length] => 17
                                        )
    
                                    [weight] => 3.00
                                    [insurance_value] => 10.10
                                    [products] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => x
                                                    [quantity] => 1
                                                )
    
                                        )
    
                                )
    
                        )
    
                    [additional_services] => Array
                        (
                            [receipt] => 
                            [own_hand] => 
                            [collect] => 
                        )
    
                    [company] => Array
                        (
                            [id] => 2
                            [name] => Jadlog
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/jadlog.png
                        )
    
                )
    
            [4] => Array
                (
                    [id] => 17
                    [name] => Mini Envios
                    [error] => Dimensões do objeto ultrapassam o limite da transportadora.
                    [company] => Array
                        (
                            [id] => 1
                            [name] => Correios
                            [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                        )
                )
        )
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

print_r($freightCalculationResponse);
```

Saída

```
AstrotechLabs\MelhorEnvio\AddShippingToCart\Dto\AddShippingToCartOutputData Object
(
    [id] => 9af3e9f3-e9b0-411e-959d-c566eaf81588
    [protocol] => ORD-202312198391
    [serviceId] => 2
    [price] => 615.76
    [deliveryMin] => 4
    [deliveryMax] => 5
    [status] => pending
    [payloadDetails] => Array
        (
            [id] => 9af3e9f3-e9b0-411e-959d-c566eaf81588
            [protocol] => ORD-202312198391
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
            [created_at] => 2023-12-28 00:38:48
            [updated_at] => 2023-12-28 00:38:48
            [parse_pi_at] => 
            [user] => Array
                (
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
                )

            [volumes] => Array
                (
                    [0] => Array
                        (
                            [id] => 203188
                            [height] => 43.00
                            [width] => 60.00
                            [length] => 70.00
                            [diameter] => 0.00
                            [weight] => 30.00
                            [format] => box
                            [created_at] => 2023-12-28 00:38:48
                            [updated_at] => 2023-12-28 00:38:48
                        )

                )

        )

)
```

### Compra de Fretes

```php
        $checkoutLabel = new CheckoutLabel(
            accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
            userAgent: "name project (email vinculed)",
            //isSandBox: true (Optional)
        );

        $checkoutLabelResponse = $checkoutLabel->confirmPushase(new CheckoutLabelInputData(
            orders: new OrderCollection(
                [new Order(
                    key: '67173a6e-2955-4c1c-bf94-9ef6fd399a12'
                )
                ]
            )
        ));

print_r($checkoutLabelResponse);
```
Saída

```
AstrotechLabs\MelhorEnvio\CheckoutLabel\Dto\CheckoutLabelOutputData Object
(
    [purchase] => Array
        (
            [id] => 9af3f9dd-36a1-4cf2-bd4a-69a5bf901bdd
            [protocol] => PUR-20231235452
            [total] => 615.76
            [discount] => 107.05
            [status] => paid
            [paid_at] => 2023-12-28 01:23:17
            [canceled_at] => 
            [created_at] => 2023-12-28 01:23:17
            [updated_at] => 2023-12-28 01:23:17
            [payment] => 
            [transactions] => Array
                (
                    [0] => Array
                        (
                            [id] => 9af3f9dd-4798-4f4f-9854-cbd28ca35ae8
                            [protocol] => TRN-20231274999
                            [value] => 615.76
                            [type] => debit
                            [status] => authorized
                            [description] => Pagamento de envios (PUR-20231235452)
                            [authorized_at] => 2023-12-28 01:23:17
                            [unauthorized_at] => 
                            [reserved_at] => 
                            [canceled_at] => 
                            [created_at] => 2023-12-28 01:23:17
                            [description_internal] => 
                            [reason] => Array
                                (
                                    [id] => 7
                                    [label] => Pagamento de envios
                                    [description] => 
                                )

                        )

                )

            [orders] => Array
                (
                    [0] => Array
                        (
                            [id] => 9af3f99a-301e-4239-9c3d-7cb7e7bb3825
                            [protocol] => ORD-202312198392
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
                            [paid_at] => 2023-12-28 01:23:17
                            [generated_at] => 
                            [posted_at] => 
                            [delivered_at] => 
                            [canceled_at] => 
                            [suspended_at] => 
                            [expired_at] => 
                            [created_at] => 2023-12-28 01:22:33
                            [updated_at] => 2023-12-28 01:23:17
                            [parse_pi_at] => 
                            [from] => Array
                                (
                                    [name] => Srta. Eloah Serna Rezende Jr.
                                    [phone] => 
                                    [email] => coelhopietro17@gmail.com
                                    [document] => 
                                    [company_document] => 93472569000130
                                    [state_register] => 
                                    [postal_code] => 8552070
                                    [address] => Jardim sem Oliveiras
                                    [location_number] => 
                                    [complement] => 
                                    [district] => 
                                    [city] => Cidade dos Empregados
                                    [state_abbr] => SP
                                    [country_id] => BR
                                    [latitude] => 
                                    [longitude] => 
                                    [note] => 
                                    [economic_activity_code] => 
                                )

                            [to] => Array
                                (
                                    [name] => Sra. Ellen Garcia Sobrinho
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
                                )

                            [service] => Array
                                (
                                    [id] => 2
                                    [name] => SEDEX
                                    [status] => available
                                    [type] => express
                                    [range] => interstate
                                    [restrictions] => {"insurance_value":{"min":0,"max":10000,"max_dec":1000},"formats":{"box":{"weight":{"min":0.001,"max":30},"width":{"min":11,"max":100},"height":{"min":2,"max":100},"length":{"min":16,"max":100},"sum":200},"roll":{"weight":{"min":0.001,"max":30},"diameter":{"min":5,"max":91},"length":{"min":18,"max":100},"sum":200},"letter":{"weight":{"min":0.001,"max":0.5},"width":{"min":11,"max":60},"length":{"min":16,"max":60}}}}
                                    [requirements] => ["names","addresses","documents"]
                                    [optionals] => ["AR","MP","VD"]
                                    [company] => Array
                                        (
                                            [id] => 1
                                            [name] => Correios
                                            [has_grouped_volumes] => 0
                                            [status] => available
                                            [picture] => /images/shipping-companies/correios.png
                                            [tracking_link] => https://www.melhorrastreio.com.br/rastreio/
                                            [use_own_contract] => 
                                            [batch_size] => 1
                                        )

                                )

                            [agency] => 
                            [invoice] => 
                            [tags] => Array
                                (
                                )

                            [products] => Array
                                (
                                )

                        )

                )

        )

    [payloadDetail] => Array
        (
            [purchase] => Array
                (
                    [id] => 9af3f9dd-36a1-4cf2-bd4a-69a5bf901bdd
                    [protocol] => PUR-20231235452
                    [total] => 615.76
                    [discount] => 107.05
                    [status] => paid
                    [paid_at] => 2023-12-28 01:23:17
                    [canceled_at] => 
                    [created_at] => 2023-12-28 01:23:17
                    [updated_at] => 2023-12-28 01:23:17
                    [payment] => 
                    [transactions] => Array
                        (
                            [0] => Array
                                (
                                    [id] => 9af3f9dd-4798-4f4f-9854-cbd28ca35ae8
                                    [protocol] => TRN-20231274999
                                    [value] => 615.76
                                    [type] => debit
                                    [status] => authorized
                                    [description] => Pagamento de envios (PUR-20231235452)
                                    [authorized_at] => 2023-12-28 01:23:17
                                    [unauthorized_at] => 
                                    [reserved_at] => 
                                    [canceled_at] => 
                                    [created_at] => 2023-12-28 01:23:17
                                    [description_internal] => 
                                    [reason] => Array
                                        (
                                            [id] => 7
                                            [label] => Pagamento de envios
                                            [description] => 
                                        )

                                )

                        )

                    [orders] => Array
                        (
                            [0] => Array
                                (
                                    [id] => 9af3f99a-301e-4239-9c3d-7cb7e7bb3825
                                    [protocol] => ORD-202312198392
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
                                    [paid_at] => 2023-12-28 01:23:17
                                    [generated_at] => 
                                    [posted_at] => 
                                    [delivered_at] => 
                                    [canceled_at] => 
                                    [suspended_at] => 
                                    [expired_at] => 
                                    [created_at] => 2023-12-28 01:22:33
                                    [updated_at] => 2023-12-28 01:23:17
                                    [parse_pi_at] => 
                                    [from] => Array
                                        (
                                            [name] => Srta. Eloah Serna Rezende Jr.
                                            [phone] => 
                                            [email] => coelhopietro17@gmail.com
                                            [document] => 
                                            [company_document] => 93472569000130
                                            [state_register] => 
                                            [postal_code] => 8552070
                                            [address] => Jardim sem Oliveiras
                                            [location_number] => 
                                            [complement] => 
                                            [district] => 
                                            [city] => Cidade dos Empregados
                                            [state_abbr] => SP
                                            [country_id] => BR
                                            [latitude] => 
                                            [longitude] => 
                                            [note] => 
                                            [economic_activity_code] => 
                                        )

                                    [to] => Array
                                        (
                                            [name] => Sra. Ellen Garcia Sobrinho
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
                                        )

                                    [service] => Array
                                        (
                                            [id] => 2
                                            [name] => SEDEX
                                            [status] => available
                                            [type] => express
                                            [range] => interstate
                                            [restrictions] => {"insurance_value":{"min":0,"max":10000,"max_dec":1000},"formats":{"box":{"weight":{"min":0.001,"max":30},"width":{"min":11,"max":100},"height":{"min":2,"max":100},"length":{"min":16,"max":100},"sum":200},"roll":{"weight":{"min":0.001,"max":30},"diameter":{"min":5,"max":91},"length":{"min":18,"max":100},"sum":200},"letter":{"weight":{"min":0.001,"max":0.5},"width":{"min":11,"max":60},"length":{"min":16,"max":60}}}}
                                            [requirements] => ["names","addresses","documents"]
                                            [optionals] => ["AR","MP","VD"]
                                            [company] => Array
                                                (
                                                    [id] => 1
                                                    [name] => Correios
                                                    [has_grouped_volumes] => 0
                                                    [status] => available
                                                    [picture] => /images/shipping-companies/correios.png
                                                    [tracking_link] => https://www.melhorrastreio.com.br/rastreio/
                                                    [use_own_contract] => 
                                                    [batch_size] => 1
                                                )

                                        )

                                    [agency] => 
                                    [invoice] => 
                                    [tags] => Array
                                        (
                                        )

                                    [products] => Array
                                        (
                                        )

                                )

                        )

                )

            [conciliation_group] => Array
                (
                    [id] => 9af3f9dc-e67c-4da6-aa33-7929182e2327
                    [protocol] => CGP-20231211801
                    [total] => 11
                    [type] => debit
                    [status] => paid
                    [paid_at] => 2023-12-28 01:23:17
                    [canceled_at] => 
                    [created_at] => 2023-12-28 01:23:17
                    [updated_at] => 2023-12-28 01:23:17
                    [conciliations] => Array
                        (
                            [0] => Array
                                (
                                    [status] => paid
                                    [service_code] => 
                                    [from_postal_code] => 48261932
                                    [from_city] => Cynthia do Sul
                                    [from_state_abbr] => BA
                                    [to_postal_code] => 36084790
                                    [to_city] => Rivera do Leste
                                    [to_state_abbr] => MG
                                    [authorization_code] => 2023122614
                                    [tracking] => ME2300491L9BR
                                    [quote] => 439.41
                                    [price] => 439.41
                                    [discount] => 54.5
                                    [value] => 11
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
                                    [paid_at] => 2023-12-28 01:23:17
                                    [canceled_at] => 
                                    [created_at] => 2023-12-26 14:40:11
                                    [updated_at] => 2023-12-28 01:23:17
                                    [rate] => 
                                    [user] => Array
                                        (
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
                                        )

                                    [group] => Array
                                        (
                                            [id] => 9af3f9dc-e67c-4da6-aa33-7929182e2327
                                            [protocol] => CGP-20231211801
                                            [total] => 11
                                            [type] => debit
                                            [status] => paid
                                            [paid_at] => 2023-12-28 01:23:17
                                            [canceled_at] => 
                                            [created_at] => 2023-12-28 01:23:17
                                            [updated_at] => 2023-12-28 01:23:17
                                        )

                                    [agency] => 
                                )

                        )

                    [transactions] => Array
                        (
                            [0] => Array
                                (
                                    [id] => 9af3f9dc-ea94-4396-b0f7-1be5e7c5a9ea
                                    [protocol] => TRN-20231274998
                                    [value] => 11
                                    [type] => debit
                                    [status] => authorized
                                    [description] => Pagamento de pendências via conferência de postagens (CGP-20231211801)
                                    [authorized_at] => 2023-12-28 01:23:17
                                    [unauthorized_at] => 
                                    [reserved_at] => 
                                    [canceled_at] => 
                                    [created_at] => 2023-12-28 01:23:17
                                    [description_internal] => 
                                    [reason] => Array
                                        (
                                            [id] => 8
                                            [label] => Pagamento de pendência via conferência de postagens
                                            [description] => 
                                        )

                                )

                        )

                    [payment] => 
                )

            [digitable] => 
            [redirect] => 
            [message] => 
            [token] => 
            [payment_id] => 
        )

)
```

### Geração de Etiquetas

```php
        $generateLabel = new GenerateLabel(
            accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
            userAgent: "name project (email vinculed)",
            //isSandBox: true (Optional)
        );

        $generateLabelResponse = $generateLabel->generate(new GenerateLabelInputData(
            orders:new OrderCollection(
                [new Order(key: "9af38965-413a-4577-be6e-44f209d47ea1")]
            )
        ));

print_r($generateLabelResponse);
```
Saída

```
AstrotechLabs\MelhorEnvio\GenerateLabel\Dto\GenerateLabelOutputData Object
(
    [details] => Array
        (
            [9af3f99a-301e-4239-9c3d-7cb7e7bb3825] => Array
                (
                    [status] => 1
                    [message] => Envio gerado com sucesso
                )

        )

)
```

## Contributing

Pull Request são bem-vindos. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## Licence

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.