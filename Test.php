<?php 
require_once("ApiConfig.php");
require_once("Barcode.php");
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON

if($input != null){
    foreach($input as $order){
        $image = checkBarcode(getApi(),$order['barcode'])->data->resim;
        echo $image;
    }
    exit();
}

echo 'asd';

?>