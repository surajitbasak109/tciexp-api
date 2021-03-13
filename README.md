# TCI Express SOAP Based API integration



## Requirements

- PHP 7.2 or greater
- php-soap
- php-json
- php-dom



## Installation



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

