<?php

namespace surajitbasak109\TciExpApi\Resources;

use surajitbasak109\TciExpApi\Clients\Client;

abstract class Resource
{
    protected $client;
    protected $credentials = null;
    protected $token = null;

    /**
     * @param Client $client
     * @param string|null $token
     */
    public function __construct(Client $client, string $token = null, $env = false)
    {
        $this->client = $client;

        $wsdl = $env ? config('tciexp.prod_wsdl') : config('tciexp.dev_wsdl');
        $this->client->setWsdl($wsdl);

        if ($token) {
            $this->token = $token;
        } else {
            $this->setCredentials();
        }
    }

    /**
     * @param string $wsdl
     *
     * @return object
     */
    public function setWsdl(string $wsdl): object
    {
        $this->client->setWsdl($wsdl);

        return $this;
    }

    /**
     * @param string $method
     * @param array $params
     *
     * @return object
     */
    public function call(string $method, array $params): object
    {
        if ($this->token) {
            $params['token'] = $this->token;
        }

        return $this->client->call($method, $params);
    }

    /**
     * Sets the credentials
     *
     * @return void
     */
    public function setCredentials(): void
    {
        $this->credentials = config('tciexp.credentials');
    }
}
