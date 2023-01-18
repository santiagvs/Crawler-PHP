<?php

use Santiagvs\Searcher\Searcher;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

require 'vendor/autoload.php';

$client = new Client(['base_uri' => 'https://www.alura.com.br']);
$crawler = new Crawler();

$searcher = new Searcher($client, $crawler);
$courses = $searcher->search('/cursos-online-programacao/php');

foreach ($courses as $course) {
  echo $course . PHP_EOL;
}
