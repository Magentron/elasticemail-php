<?php
/**
 * @author  Jeroen Derks <jeroen@derks.it>
 * @since   6/28/18
 */

namespace Tests;

use ElasticEmail\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ClientFake
 *
 * @package Tests
 */
class ClientFake extends Client
{
    /**
     * @param  string $apikey
     * @param  array  $externalMiddlewares
     * @return HandlerStack
     *
     * @see \GuzzleHttp\Client::__construct()
     */
    public function handler($apikey, array $externalMiddlewares = [])
    {
        $stack = parent::handler($apikey, $externalMiddlewares);

        $stack->after('api_error', Middleware::mapResponse(
            function (ResponseInterface $response) {
                $body = json_decode((string)$response->getBody(), true);
                if (! $body['success']) {
                    $response = $this->buildResponseFake($response);
                }

                return $response;
            }
        ), 'fake_response');

        return $stack;
    }

    /**
     * Build a fake response.
     *
     * @param  ResponseInterface|null $response
     * @return Response
     */
    private function buildResponseFake(ResponseInterface $response = null)
    {
        // return a faked response
        $body = json_encode([
            'success' => true,

            'data' => [
                'transactionid' => md5(uniqid(mt_rand(), true)),
                'messageid'     => md5(uniqid(mt_rand(), true)),
            ],
        ]);

        if (null === $response) {
            $headers = [
                'Cache-Control'                 => 'private',
                'Content-Type'                  => 'application/json; charset=utf-8',
                'Server'                        => 'Microsoft-IIS/8.5',
                'Access-Control-Allow-Origin'   => '*',
                'Access-Control-Allow-Headers'  => 'Origin, X-Requested-With, Content-Type, Accept',
                'X-Robots-Tag'                  => 'noindex, nofollow',
                'X-AspNet-Version'              => '4.0.30319',
                'X-Powered-By'                  => 'ASP.NET',
                'Date'                          => date('r'),
                'Content-Length'                => strlen($body),
            ];
        } else {
            $headers = $response->getHeaders();
        }

        return new Response(200, $headers, $body, '1.1', 'OK');
    }
}
