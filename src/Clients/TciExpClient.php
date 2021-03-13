<?php

namespace surajitbasak109\TciExpApi\Clients;

use SoapClient;

class TciExpClient implements Client
{
    public $wsdl = "https://customerapitesting.tciexpress.in/ServiceEnquire.asmx?WSDL";

    /**
     * Calls the Soap Client
     *
     * @param string $method
     * @param array $data
     *
     * @return object
     */
    public function call(string $method, array $data): object
    {
        $client = new SoapClient($this->wsdl);
        $response = $client->{$method}($data);

        return $response;
    }

    /**
     * Sets the wsdl url
     *
     * @param mixed $wsdl
     *
     * @return object
     */
    public function setWsdl($wsdl): object
    {
        $this->wsdl = $wsdl;

        return $this;
    }
}
