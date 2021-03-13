<?php

namespace surajitbasak109\TciExpApi\Resources;

use surajitbasak109\TciExpApi\Clients\Client;

abstract class Resource
{
    protected $client;
    protected $credentials =  null;
    protected $token = null;

    /**
     * @param Client $client
     * @param string|null $token
     */
    public function __construct(Client $client, string $token = null)
    {
        $this->client = $client;
        if ($token) {
            $this->token = $token;
        } else {
            $this->credentials = $this->setCredentials();
        }
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
    public function setCredentials(): void {
        $this->credentials = config('tciexp.credentials');
    }
}
