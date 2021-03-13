<?php

namespace surajitbasak109\TciExpApi\Resources;

use stdClass;
use surajitbasak109\TciExpApi\Exceptions\TciExpApiException;

class ConsignmentResource extends Resource
{
    /**
     * Creates consignment
     *
     * @param array $consignment parameters
     *
     * @return object
     */
    public function createConsignment(array $consignment = []): object
    {
        if (empty($consignment)) {
            throw new TciExpApiException("Cosignment is empty");
        }

        $action = "createConsignment";

        $response = $this->call($action, $consignment);

        return $response && $response->createConsignment
            ? $response->createConsignment
            : [];
    }


    /**
     * Creates Consignment for Ecom
     *
     * @param array $consignment Consignment parameters
     *
     * @return object
     */
    public function createConsignmentEcom(array $consignment = []): object
    {
        if (empty($consignment)) {
            throw new TciExpApiException("Cosignment is empty");
        }

        $action = "createConsignmentEcom";

        $response = $this->call($action, $consignment)->createConsignmentEcomResult;

        return $response && isset($response->createConsignmentEcomResult)
            ? $response->createConsignmentEcomResult
            : ($response ? $response : []);
    }

    public function getConsignmentResponseMessage(string $pConsignmentNumber = null)
    {
        if (!$pConsignmentNumber) {
            throw new TciExpApiException("Consignment Number cannot be empty");
        }

        $params = [
            "pConsignmentNumber" => $pConsignmentNumber,
            "pUserProfile" => [
                "UserID" => $this->client->credentials["username"],
                "Password" => $this->client->credentials["password"]
            ]
        ];

        $action = "getConsignmentResponseMessage";

        $response = $this->call($action, $params);

        return $response && isset($response->createConsignmentEcomResult)
            ? $response->createConsignmentEcomResult
            : ($response ? $response : []);
    }
}
