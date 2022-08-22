<?php 
require_once("ApiConfig.php");


$propertiesJSON = array('properties' => ['products'=>[]]);
$prod = [
    "connectedCategories"=> "[]",
    "connectedProducts"=> "[]",
    "customPrice"=> "",
    "customPriceSource"=> "0",
    "description"=> "Ön BAS",
    "fitImageToCanvas"=> "Yes",
    "hasExpandedOption"=> "",
    "hasQuantity"=> "1",
    "hasSpecialPricing"=> "",
    "icon"=> "",
    "images"=> "[\"https=>//www.jotform.com/uploads/benmithat18/form_files/attack-on-titan-eren-on-arka-baskili-tisort-650x650.jpg?nc=1\"]",
    "isLowStockAlertEnabled"=> "No",
    "isStockControlEnabled"=> "Yes",
    "lowStockValue"=> "",
    "name"=> "INTERN TSHIRT",
    "options"=> "[{\"type\":\"quantity\",\"properties\":\"1\\n2\\n3\\n4\\n5\\n6\\n7\\n8\\n9\\n10\",\"name\":\"Quantity\",\"defaultQuantity\":\"\",\"specialPricing\":false,\"specialPrices\":\"\",\"expanded\":false}]",
    "period"=> "Monthly",
    "pid"=> "100",
    "price"=> "1000",
    "recurringtimes"=> "No Limit",
    "required"=> "",
    "selected"=> "",
    "setupfee"=> "",
    "showSubtotal" => "0",
    "stockQuantityAmount" => "200",
    "trial" => ""
];

array_push($propertiesJSON['properties']['products'],$prod);
array_push($propertiesJSON['properties']['products'],$prod);
print_r( getApi()->setMultipleFormProperties(222122770297050, json_encode($propertiesJSON)));

?>