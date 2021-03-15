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

    /**
     * Gets the consignment response message
     *
     * @param string|null $pConsignmentNumber
     *
     * @return object
     */
    public function getConsignmentResponseMessage(string $pConsignmentNumber = null): object
    {
        if (!$pConsignmentNumber) {
            throw new TciExpApiException("Consignment Number cannot be empty");
        }

        $params = [
            "pConsignmentNumber" => $pConsignmentNumber,
            "pUserProfile" => [
                "UserID" => $this->credentials["username"],
                "Password" => $this->credentials["password"]
            ]
        ];

        $action = "getConsignmentResponseMessage";

        $response = $this->call($action, $params);

        dd($response);

        return $response && isset($response->createConsignmentEcomResult)
            ? $response->createConsignmentEcomResult
            : ($response ? $response : []);
    }
}
