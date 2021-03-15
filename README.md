# TCI Express SOAP Based API integration



## Requirements

- PHP 7.2 or greater
- php-soap
- php-json
- php-dom



## Installation

You can install the package via composer:

```bash
composer require surajitbasak109/tciexp-api
```

You can publish config file with:

```bash
php artisan vendor:publish --provider="surajitbasak109\tciexp\TciExpServiceProvider" --tag="config"
```



## This is the contents of the published config file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default TciExpApi Credentilas
    |--------------------------------------------------------------------------
    |
    | Here you can set the default TciExpApi credentilas. However, you can pass the credentials while connecting to TciExpApi client
    |
    */

    'dev_wsdl' => env('TCI_EXPRESS_DEV_URL', 'https://customerapitesting.tciexpress.in/ServiceEnquire.asmx?WSDL'),
    'prod_wsdl' => env('TCI_EXPRESS_PROD_URL', 'https://customerapi.tciexpress.in/ServiceEnquire.asmx?WSDL'),

    'credentials' => [
        'username' => env('TCI_EXPRESS_USERNAME', 'username'),
        'password' => env('TCI_EXPRESS_PASSWORD', 'secret')
    ]
];
```



Add this class path below the service provider of the `config/app.php` file:
```php
'providers' => [
	...
	surajitbasak109\TciExpApi\TciExpServiceProvider::class
];
```



## API Integration Process

### Create Token

From below example you can generate a token to create new consignment. You can shorten this code by creating a helper function in your Laravel project.

```php
if (session('tci_token')) {
    $token = session('tci_token');
} else {
    $token = TciExp::getToken(); // Use API to generate token
    session('tci_token', $token);
}
```



### Create Consignment (Ecom)

Here is the sample code to create consignment:

```php
$consignment = new stdClass();
$consignment->barcodes = [
    "Barcodes" => ["barcode" => 2378529716],
    "Barcodes" => ["barcode" => 2378529731],
];
$consignment->CustomerOrderNumber = "211115";
$consignment->OrderReferenceNumber = "211115";
$consignment->BranchCode = "";
$consignment->CustomerCode = "";
$consignment->AWBNumber = "5006600060";
$consignment->AWBDate = "03-11-2017 16:02:54";
$consignment->PlantCode = "A001";
$consignment->PaymentMode = "COD";
$consignment->TotalAmount = 1000;
$consignment->PayableAmount = 1000;
$consignment->Invoices = [
    "InvoiceDetail" => [
        "invoiceDate" => "14-07-2017 12:00:00",
        "invoiceNo" => "5",
        "invoiceValue" => 1000.00,
        "numberOfBoxes" => 3,
        "remarks" => "This is a test consignment"
    ]
];
$consignment->Volumes = [
    "VolumeDetail" => [
        "breadth" => 8,
        "height" => 1,
        "length" => 2,
        "numberOfBoxes" => 1,
        "volume" => 6
    ],
    "VolumeDetail" => [
        "breadth" => 34,
        "height" => 65,
        "length" => 45,
        "numberOfBoxes" => 2,
        "volume" => 60
    ]
];
$consignment->CustomerFirstName = "MR K. Ramchandran";
$consignment->CustomerLastName = "";
$consignment->CustomerAddress1 = "House No 435, Sec - 15 , Noida";
$consignment->CustomerAddress2 = "";
$consignment->CustomerCity = "DELHI";
$consignment->CustomerState = "DELHI";
$consignment->CustomerCountry = "IN";
$consignment->CustomerPinCode = "110022";
$consignment->CustomerPhoneNumber = "5005734764";
$consignment->CustomerMobileNumber = "5005734764";
$consignment->CustomerMaskMobileNumber = "7583921266";
$consignment->CustomerEmail = "kunalpramanik3@gmail.com";
$consignment->ShipperCode = "0000W8";
$consignment->ShipperName = "Web World";
$consignment->ShipperAddress1 = "Rajokri Village. New Delhi   110038";
$consignment->ShipperAddress2 = "";
$consignment->ShipperCity = "NEW DELHI";
$consignment->ShipperState = "DELHI";
$consignment->ShipperCountry = "IN";
$consignment->ShipperPinCode = "110038";
$consignment->ShipperPhoneNo = "9873516148";
$consignment->ShipperMobileNo = "9873516148";
$consignment->ShipperEmail = "";
$consignment->ReturnToName = "Web World";
$consignment->ReturnToAddress1 = "Rajokri Village. New Delhi   110038";
$consignment->ReturnToAddress2 = "";
$consignment->ReturnToCity = "NEW DELHI";
$consignment->ReturnToState = "DELHI";
$consignment->ReturnToCountry = "IN";
$consignment->ReturnToPinCode = "110038";
$consignment->ReturnToPhoneNo = "9543516148";
$consignment->ReturnToMobileNo = "9543516148";
$consignment->ReturnToEmail = "";
$consignment->TotalPices = 3;
$consignment->ProductWeight = 35;
$consignment->VolumetricWeight = "36";
$consignment->VolumetricWeight = "36";
$consignment->ProductCategory = "Fashion";
$consignment->ProductCode = "265478957";
$consignment->ProductDescription = "Product Description goes here";
$consignment->TransportMode = "SURFACE";
$consignment->B2BFlag = "N";

$consignmentData = ['consignment' => $consignment];

$response = TciExp::consignment($token)->createConsignmentEcom($consignmentData);
```



It will return an object as a response if consignment is successful:

```json
{
	"AWBNumber": "246149120",
	"error": "SUCCESS",
	"errorMessage": "Consignment Created Successfully."
}
```

### Tracking Information

This service enable you to fetch booking, in-transit and delivery/RTO information based on
consignment number.

```php
$consignmentNo = "246149120";
$response = TciExp::consignment()->getConsignmentResponseMessage($consignmentNo);
```

### Shipping Cost Calculation

***Parameter Details***

| Parameter Name        | Data Type | Length             | Allowed                   | Description                                                  |
| --------------------- | --------- | ------------------ | ------------------------- | ------------------------------------------------------------ |
| pFromPinCode          | String    | 6                  | 0-9 (Numeric Only)        | Pickup Location Pincode from where material to be shipped.   |
| pToPinCode            | String    | 6                  | 0-9 (Numeric only)        | Destination location Pincode where material to be delivered. |
| pServiceMode          | String    |                    | SURFACE / AiR             | Mode of transportation                                       |
| pProductWeight        | Decimal   |                    | 0-9 (Numeric only)        | Weight of the product.                                       |
| pVolumetricWeight     | Decimal   |                    | 0-9 (Numeric only)        | Volumetric weight of the product. Cost will be applicable on whichever is higher. |
| pProductInvoiceAmount | Decimal   | 0-9 (Numeric only) | Invoice value of product. |                                                              |
| pCodFlag              | String    |                    | Y / N                     | Whether Cash on delivery applicable or not.                  |
| pCodAmt               | Decimal   |                    | 0-9 (Numeric only)        | COD amount in case COD consignment.                          |



This method can be used to estimate shipping cost between two different locations (Pin codes) and
weight carried.

```php
$response = TciExp::service()->getShippingCostForProductAndServiceMode(
    "700055",
    "734006",
    "SURFACE",
    1000,
    9000,
    1000,
    "N",
    0.00
);
```

### Transit Time calculation

This method can be used to estimate transit time based on two different locations.

| Parameter Name | Data Type | Length | Allowed            | Description                                                |
| -------------- | --------- | ------ | ------------------ | ---------------------------------------------------------- |
| From Pin code | String    | 6      | 0-9 (Numeric Only) | Pickup location pincode from where material to be shipped. |
| To Pin code | String | 6 | 0-9 (Numeric Only) | Destination location pincode where material to be delivered. |
| Service Mode |String||SURFACE / AIR|Mode of transportation.|
| pPickupDate |String|||Material pickup date. If it's blank value, System treat this value as current date.|
| pPickupTime |String|||Material pickup Time. If it’s blank value, System treat this value as current time. If timing is after 5:00PM, 1 extra working day will be added in to transit time.|



```php
 $response = TciExp::service()->getDomesticTransitTimeForPinCodeAndServiceMode(
     "700055",
     "734006",
     "SURFACE",
     "16/03/2021",
     "10:00"
 );
```

### Check Service Availability by Pin code

With this service call you can check if Ecom Express gives service on this region or not:

```php
$response = TciExp::service()->getPincodeServiceableStatus("734006");
```

**Response:**

```json
{
    "Value": "734006",
    "Status": "SERVICEABLE",
    "Type": "",
    "DestinationCode": "XSLG",
    "DestinationCity": "SILIGURI",
    "DestinationGSTIN": "19AADCT0663J1Z5"
}
```

