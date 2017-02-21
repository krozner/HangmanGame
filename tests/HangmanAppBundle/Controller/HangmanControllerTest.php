<?php

namespace Tests\HangmanAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HangmanControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    public function testScriptsRender()
    {
        $this->client->request('GET', '/scripts.js');

        $headers = $this->client->getResponse()->headers->getIterator()->getArrayCopy();

        $this->assertContains('application/javascript', $headers['content-type']);
    }

    public function testShowUi()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hangman")')->count());
    }
}
