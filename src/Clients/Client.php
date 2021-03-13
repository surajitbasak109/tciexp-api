<?php

namespace surajitbasak109\TciExpApi\Clients;

interface Client
{
    public function call(string $method, array $data);

    public function setWsdl($wsdl);
}
