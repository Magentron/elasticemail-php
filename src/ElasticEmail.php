<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since 6/5/16
 */

namespace ElasticEmail;

use ElasticEmail\Email\Email;

/** Access to various categories API end points. */
class ElasticEmail
{
    /** @var Client */
    private $client;

    public function __construct($apiKey)
    {
        $this->client = new Client($apiKey);
    }

    /** @return Email */
    public function email()
    {
        return new Email($this->client);
    }
}
