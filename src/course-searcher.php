<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('GET', 'https://alura.com.br');

$html = $response->getBody();

echo $html . PHP_EOL;
