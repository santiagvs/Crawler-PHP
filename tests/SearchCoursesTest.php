<?php

namespace Santiagvs\Searcher\Tests;

use Santiagvs\Searcher\Searcher;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\DomCrawler\Crawler;

class SearchCoursesTest extends TestCase
{
  private $httpClientMock;
  private $url = 'url-teste';

  protected function setUp(): void
  {
    $html = <<<FIM
        <html>
            <body>
                <span class="card-curso__nome">Curso Teste 1</span>
                <span class="card-curso__nome">Curso Teste 2</span>
                <span class="card-curso__nome">Curso Teste 3</span>
            </body>
        </html>
        FIM;

    $stream = $this->createMock(StreamInterface::class);
    $stream->method('__toString')->willReturn($html);

    $response = $this->createMock(ResponseInterface::class);
    $response->method('getBody')->willReturn($stream);

    $httpClient = $this->createMock(ClientInterface::class);
    $httpClient->method('request')->with('GET', $this->url)->willReturn($response);

    $this->httpClientMock = $httpClient;
  }

  public function testShouldReturnCourses()
  {
    $crawler = new Crawler();
    $searcher = new Searcher($this->httpClientMock, $crawler);
    $courses = $searcher->search($this->url);

    $this->assertCount(3, $courses);
    $this->assertEquals('Curso Teste 1', $courses[0]);
    $this->assertEquals('Curso Teste 2', $courses[1]);
    $this->assertEquals('Curso Teste 3', $courses[2]);
  }
}
