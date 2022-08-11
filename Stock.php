<?php 
require_once("ApiConfig.php");
require_once("Service/AuthManager.php");


if(isset($_POST['addStock'])){

    $authManager = new AuthManager();
    $user = $authManager->verifyUserToken($_POST['token']);
    $stockFormID = $user->getUserStockId();
    AddStock($jotformAPI,$stockFormID);
}else{
    echo json_encode("Invalid request");
    exit();
}
function addStock($jotformAPI,$stockFormID){
    
    $image = imageUpload();

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
    $result = $jotformAPI->createFormSubmission($stockFormID, $submission);

    print_r($result);
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
?>