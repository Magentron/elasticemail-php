<?php
/**
 * @author  Rizart Dokollari <r.dokollari@gmail.com>
 * @author  Jeroen Derks <jeroen@derks.it>
 * @since   12/24/17
 */

namespace Tests\Email;

use ElasticEmail\Client;
use ElasticEmail\ElasticEmail;
use ElasticEmail\Email\Send;
use Tests\ClientFake;
use Tests\TestCase;

class SendTest extends TestCase
{
    const DEFAULT_EMAIL = 'hello@example.org';

    /** @test */
    public function appends_api_key()
    {
        $this->appendsApiKey(Send::class);
    }

    /** @test */
    public function send_an_email()
    {
        $baseDirectory = __DIR__ . '/../..';

        $envFilename = '.env';
        if (!file_exists("{$baseDirectory}/{$envFilename}")) {
            $envFilename .= '.example';
        }
        $dotenv = new \Dotenv\Dotenv($baseDirectory, $envFilename);

        $dotenv->load();

        $apiKey = getenv('ELASTIC_EMAIL_API_KEY') ?: md5(uniqid(mt_rand(), true));
        if (getenv('TEST_REAL_API', false)) {
            $client = new Client($apiKey);
        } else {
            $client = new ClientFake($apiKey);
        }

        $send = new Send($client);

        $response = $send->handle([
            'to'      => getenv('MAIL_TO', self::DEFAULT_EMAIL),
            'from'    => getenv('MAIL_FROM', self::DEFAULT_EMAIL),
            'subject' => subject(__FUNCTION__),
        ]);

        $this->assertNotEmpty($response->getResponse());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->wasSuccessful());

        $this->assertEquals(null, $response->code());
        $this->assertEquals(null, $response->context());
        $this->assertEquals(null, $response->error());
    }

    /** @test */
    public function forward_params_as_http_query()
    {
        $client = $this->getMockBuilder(Client::class)
            ->setConstructorArgs(['api-key'])
            ->getMock();

        $params = ['any-parameter' => 'any-parameter-value'];

        $expectedParams = ['form_params' => $params];

        $client->expects($this->once())
            ->method('request')
            ->with('POST', Send::URI, $expectedParams);

        /** @var Client $client */

        $send = new Send($client);

        $send->handle($params);
    }

    /** @test */
    public function use_multipart_option_to_send_files()
    {
        $client = $this->getMockBuilder(Client::class)
            ->setConstructorArgs(['api-key'])
            ->getMock();

        $params = [$name = 'any-parameter' => $content = 'any-parameter-value'];

        $expectedParams = ['multipart' => [
            [
                'name'     => $name,
                'contents' => $content
            ]
        ]];

        $client->expects($this->once())
            ->method('request')
            ->with('POST', Send::URI, $expectedParams);

        /** @var Client $client */

        $send = new Send($client);

        $send->handle($params, true);
    }
}
