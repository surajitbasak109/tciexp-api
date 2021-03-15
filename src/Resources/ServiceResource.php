<?php

namespace surajitbasak109\TciExpApi\Resources;

use SimpleXMLElement;
use stdClass;
use surajitbasak109\TciExpApi\Exceptions\TciExpApiException;

/**
 * ServiceResource
 */
class ServiceResource extends Resource
{
    /**
     * Get shipping cost for product and service mode
     *
     * @param string|null   $fromPincode        Pickup Location Pincode from where material to be shipped.
     * @param string|null   $toPincode          Destination location Pincode where material to be delivered.
     * @param string|null   $serviceMode        Mode of transportation (AIR or SURFACE)
     * @param float|null    $productWeight      Weight of the product.
     * @param float|null    $volumetricWeight   Volumetric weight of the product. Cost will be applicable on whichever is higher.
     * @param float|null    $productInvoiceAmt  Invoice value of product.
     * @param string        $codFlag            Whether Cash on delivery applicable or not.
     * @param float|null    $codAmt             COD amount in case COD consignment.
     *
     * @return object
     */

    public function getShippingCostForProductAndServiceMode(
        string $fromPincode = null,
        string $toPincode = null,
        string $serviceMode = null,
        float $productWeight = null,
        float $volumetricWeight = null,
        float $productInvoiceAmt = null,
        string $codFlag = "N",
        float $codAmt = null
    ): object {
        if (!$fromPincode && !$toPincode && !$serviceMode && !$productWeight && !$productInvoiceAmt && !$codFlag) {
            throw new TciExpApiException("Check mandatory fields: fromPincode, toPincode, serviceMode, productWeight, productInvoiceAmt and codFlag");
        }

        if ($codFlag == "Y" && !$codAmt) {
            throw new TciExpApiException("COD amount is required if codFlag set to Y");
        }

        $action = "getShippingCostForProductAndServiceMode";

        $params = [
            "pFromPinCode" => $fromPincode,
            "pToPinCode" => $toPincode,
            "pServiceMode" => $serviceMode,
            "pProductWeight" => (float) $productWeight,
            "pVolumetricWeight" => (float) $volumetricWeight,
            "pProductInvoiceAmount" => (float) $productInvoiceAmt,
            "pCodFlag" => $codFlag,
            "pCodAmt" => (float) $codAmt,
            "pProfile" => [
                "UserID" => $this->credentials["username"],
                "Password" => $this->credentials["password"]
            ]
        ];

        $response = $this->client->call($action, $params);

        return $response && isset($response->getShippingCostForProductAndServiceModeResult)
            ? $response->getShippingCostForProductAndServiceModeResult
            : ($response ? $response : []);
    }

    /**
     * Gets doemstic transit time for pincode and service mode
     *
     * @param string|null $fromPincode  Pickup Location Pincode from where material to be shipped.
     * @param string|null $toPincode    Destination Location Pincode where material to be delivered.
     * @param string|null $serviceMode  Mode of transportation. (SURFACE/AIR)
     * @param string|null $pickupDate   Material pickup date. If it’s blank value,
     * System treat this value as current date.
     * @param string|null $pickupTime   Material pickup Time. If it’s blank value,
     * System treat this value as current time. If timing is after 5:00PM, 1 extra
     * working day will be added in to transit time.
     *
     * @return object
     */
    public function getDomesticTransitTimeForPinCodeAndServiceMode(string $fromPincode = null, string $toPincode = null, string $serviceMode = null, string $pickupDate = null, string $pickupTime = null): object
    {
        if (!$fromPincode && !$toPincode && !$serviceMode) {
            throw new TciExpApiException("origin pincode, destination pincode and service mode is required");
        }

        $params = [
            "pFromPinCode" => $fromPincode,
            "pToPinCode" => $toPincode,
            "pServiceMode" => $serviceMode,
            "pPickupDate" => $pickupDate,
            "pPickupTime" => $pickupTime,
            "pProfile" => [
                "UserID" => $this->credentials["username"],
                "Password" => $this->credentials["password"]
            ]
        ];

        $action = "getDomesticTransitTimeForPinCodeAndServiceMode";

        $response = $this->client->call($action, $params);

        return $response && isset($response->getDomesticTransitTimeForPinCodeAndServiceModeResult)
            ? $response->getDomesticTransitTimeForPinCodeAndServiceModeResult
            : ($response ? $response : []);
    }

    public function getPincodeServiceableStatus(string $pincode)
    {
        $regex = "/^[1-9][0-9]{5}$/i";
        if(!preg_match($regex, $pincode)) {
            throw new TciExpApiException("The given Pin code is invalid");
        }

        $params = [
            "pPinCodes" => $pincode,
            "pProfile" => [
                "UserID" => $this->credentials["username"],
                "Password" => $this->credentials["password"]
            ]
        ];

        $action = "getPincodeServiceableStatus";

        $response = $this->client->call($action, $params);

        $data = $response->getPincodeServiceableStatusResult->any;

        $xml = new SimpleXMLElement($data);
        $json = $xml->PinCode;

        $output = [];
        foreach ($json->attributes() as $key => $value) {
            $output[$key] = (string) $value;
        }

        return response()->json($output);
    }
}
