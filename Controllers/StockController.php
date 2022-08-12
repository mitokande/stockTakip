<?php 
require_once("ApiConfig.php");
require_once("Entities/Product.php");
require_once("Service/AuthManager.php");


class StockController{
    
function addStock($stockFormID){
    
    $image = $this->imageUpload();

    $submission = array(
        "5" => $_POST['urunAdi'],
        "6" => $_POST['barcode'],
        "7" => $_POST['stok'],
        "8" => $_POST['fiyat'],
        "14" => $image,
        "15" => $_POST['ad'],
        "13" => $_POST['email']
    );

    // $result = $jotformAPI->createFormSubmission("222202437411037", $submission);
    $result = getApi()->createFormSubmission($stockFormID, $submission);

    echo json_encode($result);
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
    if(move_uploaded_file($image_file["tmp_name"],__DIR__ . "/images/" . $image_file["name"])){
        return __DIR__ . "/images/" . $image_file["name"];
    }
}


function getStocks($stockFormId){
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
    echo json_encode($stocks);

}
}


?>