<?php

namespace surajitbasak109\TciExpApi;

use surajitbasak109\TciExpApi\Clients\TciExpClient;
use surajitbasak109\TciExpApi\Resources\ConsignmentResource;
use surajitbasak109\TciExpApi\Resources\ServiceResource;

class TciExpApi
{
    public $client;

    public function __construct(TciExpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Sets the wsdl
     *
     * @param null $wsdl
     *
     * @return object
     */
    public function setWsdl($wsdl = null): object
    {
        if ($wsdl) {
            $this->client->setWsdl($wsdl);
        }

        return $this;
    }

    /**
     * Gets the token
     *
     * @return string
     */
    public function getToken(): string
    {
        $response = $this->client->call('getToken', config('tciexp.credentials'));

        return $response->getTokenResult;
    }

    public function consignment(string $token = null)
    {
        return $token ? new ConsignmentResource($this->client, $token) : new ConsignmentResource($this->client);
    }

    public function service()
    {
        return new ServiceResource($this->client);
    }
}
