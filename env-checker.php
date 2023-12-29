<?php

declare(strict_types=1);

use Dotenv\Exception\ValidationException;
use Dotenv\Exception\InvalidPathException;

require __DIR__ . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
    $dotenv->load();

    $dotenv->required('COMPOSE_PROJECT_NAME')->notEmpty();
    $dotenv->required('APP_TIMEZONE')->notEmpty();
    $dotenv->required('APP_ENV')->notEmpty()->allowedValues(['dev', 'staging', 'production']);
    $dotenv->required('MELHOR_ENVIO_API_TOKEN')->notEmpty();
    $dotenv->required('MELHOR_ENVIO_USER_AGENT')->notEmpty();
    $dotenv->required('MELHOR_ENVIO_SANDBOX')->notEmpty();

    echo '===================================================' . PHP_EOL;
    echo "System environment variables are ok!" . PHP_EOL;
    echo '===================================================' . PHP_EOL;
    exit(0);
} catch (ValidationException | InvalidPathException $e) {
    echo '===================================================' . PHP_EOL;
    echo "!!! ERROR ON VALIDATE ENV VARIABLES !!!" . PHP_EOL;
    echo '===================================================' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}
