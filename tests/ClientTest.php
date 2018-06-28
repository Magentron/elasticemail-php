<?php
/**
 * @author  Rizart Dokollari <r.dokollari@gmail.com>
 * @author  Jeroen Derks <jeroen@derks.it>
 * @since   12/24/17
 */

namespace Tests;

use ElasticEmail\Client;
use ElasticEmail\Email\Send;
use ElasticEmail\ElasticEmailException;

class ClientTest extends TestCase
{
    const API_KEY = 'api-key';

    /** @var  Client */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client(self::API_KEY);
    }

    /** @test */
    public function uses_correct_api_base_uri()
    {
        $actualBaseUri = (string)$this->client->getConfig('base_uri');

        $this->assertEquals(Client::$baseUri, $actualBaseUri);
    }

    /** @test */
    public function throws_type_error_api_key_exception()
    {
        $this->expectException(\TypeError::class);

        new Client(null);
    }

    /** @test */
    public function throws_missing_api_key_exception()
    {
        $this->expectException(ElasticEmailException::class);
        $this->expectExceptionMessage('ElasticEmail API key is missing.');

        new Client('');
    }

    /** @test */
    public function throws_invalid_api_key_exception()
    {
        $this->expectException(ElasticEmailException::class);
        $this->expectExceptionMessage('Incorrect apikey');

        $client = new Client('This is an invalid API key');
        $send   = new Send($client);

        $send->handle([]);
    }
}
