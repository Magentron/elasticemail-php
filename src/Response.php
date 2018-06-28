<?php
/**
 * @author  Rizart Dokollari <r.dokollari@gmail.com>
 * @author  Jeroen Derks <jeroen@derks.it>
 * @since   12/24/17
 */

namespace ElasticEmail;

abstract class Response
{
    /** @var  \GuzzleHttp\Psr7\Response */
    protected $response;

    public function getResponse()
    {
        return $this->response;
    }

    public function context()
    {
        $body = $this->getBody();
        return property_exists($body, 'Context') ? $body->Context : null;
    }

    public function getBody()
    {
        return json_decode((string)$this->response->getBody());
    }

    public function wasSuccessful()
    {
        return $this->getBody()->success;
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function code()
    {
        $body = $this->getBody();
        return property_exists($body, 'Code') ? $body->Code : null;
    }

    public function error()
    {
        $body = $this->getBody();
        return property_exists($body, 'error') ? $body->error : null;
    }
}
