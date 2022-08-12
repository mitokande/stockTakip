<?php 
require_once("ApiConfig.php");
require_once("Barcode.php");
require_once("Entities/Product.php");
require_once("Service/AuthManager.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
require_once("Utilities/Result/SuccessResult.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/ErrorDataResult.php");
require_once("Utilities/Result/SuccessDataResult.php");

class StockController{
    
function addStock($jotformAPI,$stockFormID,$stockInput): DataResult
{

    foreach($stockInput as $stock){
        $image = checkBarcode($jotformAPI,$stock['barcode'])->data->resim;
        $authManager = new AuthManager();
        $user = $authManager->verifyUserToken(getallheaders()['token'])->data;
    
        $submission = array(
            "5" => $stock['urunAdi'],
            "6" => $stock['barcode'],
            "7" => $stock['stok'],
            "8" => $stock['fiyat'],
            "14" => $image,
            "15" => $user->shopName,
            "13" => $user->email
        );
    
        // $result = $jotformAPI->createFormSubmission("222202437411037", $submission);
        $result = getApi()->createFormSubmission($stockFormID, $submission);
    }

    

    return new SuccessDataResult($result,"Stock added Successfuly");
}


function imageUpload(){
    $image_file = $_FILES["image"];

    // Exit if no file uploaded
    if (!isset($image_file)) {
        die('No file uploaded.');
    }

    // Exit if is not a valid image file
    $image_type = exif_imagetype($image_file["tmp_name"]);
    if (!$image_type) {
        die('Uploaded file is not an image.');
    }

    // Move the temp image file to the images/ directory
    if(move_uploaded_file($image_file["tmp_name"],"images/" . $image_file["name"])){
        return "images/" . $image_file["name"];
    }
}


function getStocks($stockFormId) : DataResult
{
    $stockTable = getApi()->getFormSubmissions($stockFormId);
    $stocks = [];
    foreach($stockTable as $item){
        if($item['status'] == "ACTIVE"){
            $urun = new Product;
            $urun->urunAdi = $item['answers'][5]['answer'];
            $urun->barcode = $item['answers'][6]['answer'];
            $urun->resim = $item['answers'][15]['answer'];
            $urun->fiyat = $item['answers'][8]['answer'];
            $urun->adet = $item['answers'][7]['answer'];
            $stocks[] = $urun;
        }
    }
    $result = new SuccessDataResult($stocks,"Stocks listed successfuly");
    return $result;

}
}


?>