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

    /** @var object */
    protected $body = null;

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function context()
    {
        $body = $this->getBody();
        return property_exists($body, 'Context') ? $body->Context : null;
    }

    /**
     * @return object
     */
    public function data()
    {
        $body = $this->getBody();
        return property_exists($body, 'data') ? $body->data : null;
    }

    /**
     * @return object|null
     */
    public function getBody()
    {
        if (null === $this->body) {
            $this->body = json_decode((string) $this->response->getBody());
        }
        return $this->body;
    }

    /**
     * @return boolean
     */
    public function wasSuccessful()
    {
        return $this->getBody()->success;
    }

    /**
     * @return int
     */
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

    /**
     * @return string
     */
    public function messageId()
    {
        $data = $this->data();
        return property_exists($data, 'messageid') ? $data->messageid : null;
    }

    /**
     * @return string
     */
    public function transactionId()
    {
        $data = $this->data();
        return property_exists($data, 'transactionid') ? $data->transactionid : null;
    }
}
