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
    to:"xxxxxxxxxx",
    from: "xxxxxxxxx",
    extra: [
        "products" => [
            [
                "id" => 1,
                "width" => 20.05 ,
                "height" => 2.00,
                "length" => 34.00,
                "weight" => 1.00,
                "insurance_value" => 10.00,
                "quantity" => 2
            ]
        ],
        /**  "options" => [
            "insurance_value" => 1180.87,
            "receipt" => false,
            "own_hand" => false
        ],
        "services" => "1,2,3"  (Optional)*/
    ]
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
    to:"xxxxxxxxxx",
    from: "xxxxxxxxx",
    extra: [
            "package" => [
                "height" => 4,
                "width" => 12,
                "length" => 17,
                "weight" => 0.3
            ],
           /**   "options" => [
                "insurance_value" => 1180.87,
                "receipt" => false,
                "own_hand" => false
            ],
            "services" => "1,2,3" (Optional)*/
            ]
));

print_r($freightCalculationResponse);
```

Saída

```
[
    [
            [id] => 1
            [name] => PAC
            [company] => [
                    [id] => 1
                    [name] => Correios
                    [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                ]
        ],
    [
            [id] => 2
            [name] => SEDEX
            [company] => [
                    [id] => 1
                    [name] => Correios
                    [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/correios.png
                ]
        ],
    [
            [id] => 3
            [name] => .Package
            [company] => [
                    [id] => 2
                    [name] => <h1>teste</h1>
                    [picture] => https://sandbox.melhorenvio.com.br/images/shipping-companies/jadlog.png
                ]
        ]
]
```
### Inserindo Fretes no Carrinho

os campos company_document e document se referem ao CNPJ e/ou CPF

```php
$addShippingToCart = new AddShippingToCart(
accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
userAgent: "name project (email vinculed)",
//isSandBox: true (Optional)
);
$addShippingToCartResponse = $addShippingToCart->adding(new AddShippingToCartInputData(
    service: 1,
    to:[
        "name" => "xxxxxxxxxxxxxx",
        "company_document" => "pppppyyyyyy",
        "address" => "xxxxxxyyyyyyy",
        "number" => "xxxxxxxyyyyyyy",
        "city" => "xxxxxxxxyyyyyyy",
        "postal_code" => "xxxxxxxxxxxyyyy"
    ],
    from: [
        "name" => "xxxxxxxxxxxxxx",
        "document" => "xxxxxxxxxxx",
        "address" => "xxxxxxyyyyyyy",
        "number" => "xxxxxxxyyyyyyy",
        "city" => "xxxxxxxxyyyyyyy",
        "postal_code" => "xxxxxxxxxxxyyyy",
    ],
    products: [
        [
        "name" => "xxxx",
        /**  "quantity" => 1,
        "unitary_value" => 10.0 (Optional)*/
        ]
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
                "non_commercial" => true,
                /** "invoice" => ["key" => '551000007'],
                "platform" => 'plataforma inserida',
                "tags" => [[
                    "tag" => 'tag',
                    "Url" => 'url da plataforma'
                ]] (Optional) */
            ],
/** extras: [
                "agency" => 1234,
            ]  (Optional)*/
));

print_r($freightCalculationResponse);
```

Saída

```
[
  "id" => "10b87ac0-e99d-4aa4-b8b0-b147a84e16bf",
  "protocol" => "ORD-20220397305",
  "service_id" => 3,
  "agency_id" => 48,
  "contract" => null,
  "service_code" => null,
  "quote" => 25.35,
  "price" => 25.35,
  "coupon" => null,
  "discount" => 5.71,
  "delivery_min" => 5,
  "delivery_max" => 6,
  "status" => "pending",
  "reminder" => null,
  "insurance_value" => 50,
  "weight" => null,
  "width" => null,
  "height" => null,
  "length" => null,
  "diameter" => null,
  "format" => "box",
  "billed_weight" => 3.5,
  "receipt" => false,
  "own_hand" => false,
  "collect" => false,
  "collect_scheduled_at" => null,
  "reverse" => false,
  "non_commercial" => true,
  "authorization_code" => null,
  "tracking" => null,
  "self_tracking" => null,
  "delivery_receipt" => null,
  "additional_info" => null,
  "cte_key" => null,
  "paid_at" => null,
  "generated_at" => null,
  "posted_at" => null,
  "delivered_at" => null,
  "canceled_at" => null,
  "suspended_at" => null,
  "expired_at" => null,
  "created_at" => "2022-03-29 12:50:19",
  "updated_at" => "2022-03-29 12:50:19",
  "parse_pi_at" => null,
  "products" => [
    [
      "name" => "xxxx",
      "quantity" => null,
      "unitary_value" => null,
      "weight" => null
    ]
  ],
  "volumes" => [
    [
      "id" => 101594,
      "height" => "10.00",
      "width" => "15.00",
      "length" => "20.00",
      "diameter" => "0.00",
      "weight" => "3.50",
      "format" => "box",
      "created_at" => "2022-03-29 12:50:19",
      "updated_at" => "2022-03-29 12:50:19"
    ]
  ]
]
```

### Compra de Fretes

```php
        $checkoutLabel = new CheckoutLabel(
            accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
            userAgent: "name project (email vinculed)",
            //isSandBox: true (Optional)
        );

        $checkoutLabelResponse = $checkoutLabel->confirmingPushase(new CheckoutLabelInputData(
            orders:["9af0f5df-52ca-4d93-9da3-59ee5cbad865"]
        ));

print_r($checkoutLabelResponse);
```
Saída

```
[
  "purchase": [
    "id" => "f1261eb6-fa71-4cae-8267-7d332b42da4d",
    "protocol" => "PUR-20220326201",
    "total" => 25.35,
    "discount" => 5.71,
    "status" => "paid",
    "paid_at" => "2022-03-29 21:15:53",
    "canceled_at" => null,
    "created_at" => "2022-03-29 21:15:53",
    "updated_at" => "2022-03-29 21:15:53",
    "payment" => null,
    "transactions": [
      [
        "id" => "8ff6e5b5-92bb-44a6-85f1-576d15c9cb58",
        "protocol" => "TRN-20220357400",
        "value" => 25.35,
        "type" => "debit",
        "status" => "authorized",
        "description" => "Pagamento de envios (PUR-20220326201)",
        "authorized_at" => "2022-03-29 21:15:53",
        "unauthorized_at" => null,
        "reserved_at" => null,
        "canceled_at" => null,
        "created_at" => "2022-03-29 21:15:53",
        "description_internal" => null,
        "reason" => [
          "id" => 7,
          "label" => "Pagamento de envios",
          "description" => ""
        ]
      ]
    ],
    "orders": [
      [
        "id" => "d345836e-061b-490a-b01e-6f7daa2def65",
        "protocol" => "ORD-20220395511",
        "service_id" => 3,
        "agency_id" => 40,
        "contract" => null,
        "service_code" => null,
        "quote" => 25.35,
        "price" => 25.35,
        "coupon" => null,
        "discount" => 5.71,
        "delivery_min" => 5,
        "delivery_max" => 6,
        "status" => "released",
        "reminder" => null,
        "insurance_value" => 50,
        "weight" => null,
        "width" => null,
        "height" => null,
        "length" => null,
        "diameter" => null,
        "format" => "box",
        "billed_weight" => 3.5,
        "receipt" => false,
        "own_hand" => false,
        "collect" => false,
        "collect_scheduled_at" => null,
        "reverse" => false,
        "non_commercial" => false,
        "authorization_code" => null,
        "tracking" => null,
        "self_tracking" => null,
        "delivery_receipt" => null,
        "additional_info" => null,
        "cte_key" => null,
        "paid_at" => "2022-03-29 21:15:53",
        "generated_at" => null,
        "posted_at" => null,
        "delivered_at" => null,
        "canceled_at" => null,
        "suspended_at" => null,
        "expired_at" => null,
        "created_at" => "2022-03-29 20:24:10",
        "updated_at" => "2022-03-29 21:15:53",
        "parse_pi_at" => null,
        "from" => [
          "name" => "Teste ME",
          "phone" => "5598105050",
          "email" => "melhorenvio@teste.com",
          "document" => "16571478358",
          "company_document" => "04517623000197",
          "state_register" => "563025255115",
          "postal_code" => "7110000",
          "address" => "Rua Teste",
          "location_number" => "100",
          "complement" => "CASA",
          "district" => "Bairro Teste",
          "city" => "Guarulhos",
          "state_abbr" => "SP",
          "country_id" => "BR",
          "latitude" => null,
          "longitude" => null,
          "note" => "observação"
        ],
        "to" => [
          "name" => "Melhor Envio Teste",
          "phone" => "1999999999",
          "email" => "melhorenvio@teste.com",
          "document" => "73646548010",
          "company_document" => "89794131000100",
          "state_register" => "123456",
          "postal_code" => "26210000",
          "address" => "Avenida Marechal Floriano Peixoto",
          "location_number" => "123",
          "complement" => "Ap 2",
          "district" => "Centro",
          "city" => "Nova Iguacu",
          "state_abbr" => "RJ",
          "country_id" => "BR",
          "latitude" => null,
          "longitude" => null,
          "note" => "observação"
        ],
        "service" => [
          "id" => 3,
          "name" => ".Package",
          "status" => "available",
          "type" => "normal",
          "range" => "interstate",
          "restrictions" => "{\"insurance_value\":{\"min\":0,\"max\":29900},\"formats\":{\"box\":{\"weight\":{\"min\":0.001,\"max\":120},\"width\":{\"min\":1,\"max\":105},\"height\":{\"min\":1,\"max\":100},\"length\":{\"min\":1,\"max\":181},\"sum\":386}}}",
          "requirements" => "[\"names\",\"phones\",\"addresses\",\"documents\",\"invoice\"]",
          "optionals" => "[\"AR\",\"VD\"]",
          "company" => [
            "id" => 2,
            "name" => "Jadlog",
            "status" => "available",
            "picture" => "/images/shipping-companies/jadlog.png",
            "use_own_contract" => false
          ]
        ],
        "agency": [
          "id" => 40,
          "company_id" => 2,
          "name" => "CO LIMEIRA 01",
          "initials" => "CO-LMR-01",
          "code" => "1008530",
          "status" => "available",
          "company_name" => "KRONOS CARGO LTDA ME",
          "email" => "kronos.lmr@jadlog.com.br",
          "note" => null,
          "created_at" => "2017-09-11 17:47:14",
          "updated_at" => "2017-10-19 16:47:33",
          "address" => [
            "id" => 40,
            "label" => "Agência JadLog",
            "postal_code" => "13485208",
            "address" => "Rua Jose Malaman 77",
            "number" => null,
            "complement" => null,
            "district" => "Jardim Residencial Granja Machado",
            "latitude" => -22.5501559,
            "longitude" => -47.3830416,
            "confirmed_at" => null,
            "created_at" => "2017-09-11 17:47:14",
            "updated_at" => "2017-10-19 16:47:33",
            "city" => [
              "id" => 5010,
              "city" => "Limeira",
              "state" => [
                "id" => 25,
                "state" => "São Paulo",
                "state_abbr" => "SP",
                "country" => [
                  "id" => "BR",
                  "country" => "Brazil"
                ]
              ]
            ]
          ],
          "phone" => [
            "id" => 40,
            "label" => "Agência JadLog",
            "phone" => "1934433954",
            "type" => "fixed",
            "country_id" => "BR",
            "confirmed_at" => null,
            "created_at" => "2017-09-11 17:47:14",
            "updated_at" => "2017-09-11 17:47:14"
          ]
        ],
        "invoice" => [
          "model" => "55",
          "number" => "9248",
          "serie" => "1",
          "key" => "31190307586261000184550010000092481404848162",
          "value" => null,
          "cfop" => null,
          "issued_at" => "2019-03-01 00:00:00",
          "uploaded_at" => null,
          "to_document" => null
        ],
        "tags" => [],
        "products" => [
          [
            "name" => "Papel adesivo para etiquetas 1",
            "quantity" => 3,
            "unitary_value" => 100,
            "weight" => null
          ],
          [
            "name" => "Papel adesivo para etiquetas 2",
            "quantity" => 1,
            "unitary_value" => 700,
            "weight" => null
          ]
        ],
        "generated_key" => null
      ]
    ],
    "paypal_discounts" => []
  ],
  "digitable" => null,
  "redirect" => null,
  "message" => null,
  "token" => null,
  "payment_id" => null
]
```

### Geração de Etiquetas

```php
        $generateLabel = new GenerateLabel(
            accessToken: "xxxxxxxxxxxxxxx.xxxxxxxxxxxxxxxxx.xxxxxxxx",
            userAgent: "name project (email vinculed)",
            //isSandBox: true (Optional)
        );

        $generateLabelResponse = $generateLabel->generating(new GenerateLabelInputData(
            orders:["9af0f5df-52ca-4d93-9da3-59ee5cbad865"]
        ));

print_r($generateLabelResponse);
```
Saída

```
[
  "b1ad6622-50b0-4e96-b395-730544e60085" => [
    "status" => true,
    "message" => "Envio gerado com sucesso"
  ]
]
```

## Contributing

Pull Request são bem-vindos. Para mudanças importantes, abra primeiro uma issue para discutir o que você gostaria de mudar.

Certifique-se de atualizar os testes conforme apropriado.

## Licence

Este pacote é lançado sob a licença [MIT](https://choosealicense.com/licenses/mit/). Consulte o pacote [LICENSE](./LICENSE) para obter detalhes.