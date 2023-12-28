<?php

declare(strict_types=1);

use AstrotechLabs\MelhorEnvio\MelhorEnvioService;

error_reporting(E_ALL & ~E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env');
$dotenv->load();



$melhorEnvioService = new MelhorEnvioService(
    accessToken: "xxxxxx.yyyyyyy.zzzzzz",
    userAgent: "name project (email vinculed)", // esse nome e email são os dados que foram cadastrados no melhor envio
//isSandBox: true (Optional)
);

$freightCalculationResponse = $melhorEnvioService->freightCalculate(new \AstrotechLabs\MelhorEnvio\FreightCalculation\Dto\InputData(

));