<?php

namespace Santiagvs\Searcher;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Searcher
{
  private $httpClient;
  private $crawler;

  public function __construct(ClientInterface $httpClient, Crawler $crawler)
  {
    $this->httpClient = $httpClient;
    $this->crawler = $crawler;
  }

  public function search(string $url): array
  {
    $response = $this->httpClient->request('GET', $url);
    $html = $response->getBody();

    echo str_contains($html, 'span.card-curso__nome');

    $this->crawler->addHtmlContent($html);
    $courseElements = $this->crawler->filter('span.card-curso__nome');
    $courses = [];

    foreach ($courseElements as $element) {
      $courses[] = $element->textContent;
    }

    return $courses;
  }
}
