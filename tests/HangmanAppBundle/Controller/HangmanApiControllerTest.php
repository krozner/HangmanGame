<?php

namespace Tests\HangmanAppBundle\Controller;

use Hangman\Bundle\AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HangmanApiControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     */
    private function getRouteUri($name, array $parameters = [])
    {
        return $this->client->getContainer()
            ->get('router')
            ->generate($name, $parameters);
    }

    private function asserts(Response $response)
    {
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($response->headers->get('Content-Type') === 'application/json');

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('word', $data);
        $this->assertArrayHasKey('tries_left', $data);
        $this->assertArrayHasKey('origin', $data);
    }

    public function testSerializedRandomWordEntity()
    {
        $this->client->request('POST', $this->getRouteUri('hangman_api_start_game'));
        $this->asserts($this->client->getResponse());
    }

    public function testSerializedRandomWordEntityInCategory()
    {
        $gamePlay = $this->client->getContainer()
            ->get('hangman.service.game_manager')
            ->createGamePlay();

        $this->client->request('PUT', $this->getRouteUri('hangman_api_game_guess', [
            'game' => $gamePlay->getGame()->getId(),
            'letter' => 'a'
        ]));
        $this->asserts($this->client->getResponse());
    }

}
