<?php 
require_once("ApiConfig.php");
require_once("Service/AuthManager.php");
require_once("AwsTest.php");

require_once("Entities/Product.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
require_once("Utilities/Result/SuccessResult.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/ErrorDataResult.php");
require_once("Utilities/Result/SuccessDataResult.php");
header("Access-Control-Allow-Origin: *");


$barcodeJSON = file_get_contents('php://input');
$barcode = json_decode($barcodeJSON, TRUE); //convert JSON

if(isset($_POST['barcode'])){
    $authManager = new AuthManager();
    if(!empty(getallheaders()['Token'])){
        $result = $authManager->verifyUserToken(getallheaders()['Token']);
    }
    if (isset($result) && $result->success)
    {
        echo json_encode(addBarcode(getApi(),$_POST));
        exit();
    }
}else if($barcode != null){
        echo json_encode(checkBarcode(getApi(),$barcode));
}


function addBarcode($jotformAPI,$barcode): DataResult{
//not yet implemented
    // $submission = array(
    //         "5" => $stock['urunAdi'],
    //         "6" => $stock['barcode'],
    //         "7" => $stock['stok'],
    //         "8" => $stock['fiyat'],
    //         "14" => $image,
    //         "15" => $user->shopName,
    //         "13" => $user->email
    //     );
    
    //     // $result = $jotformAPI->createFormSubmission("222202437411037", $submission);
    //     $result = getApi()->createFormSubmission($stockFormID, $submission);
    
    $resim = json_decode(awsUploadPhoto())->data;
    
    $submission = array(
            "3" => $barcode['urunAdi'],
            "4" => $barcode['barcode'],
            "8" => $barcode['fiyat'],
            "9" => $resim
    );
    $result = $jotformAPI->createFormSubmission("222211745912045", $submission);
    return new SuccessDataResult($result,"New Barcode added to the database successfuly");
}

function checkBarcode($jotformAPI,$barcode): DataResult
{
    $barcodeTable = $jotformAPI->getFormSubmissions("222211745912045");
    if(count($barcode)== 1){
        $barcode = array($barcode);
    }
    $urunler = [];
    foreach($barcode as $b){
        foreach($barcodeTable as $item){
            if($item['status'] == "ACTIVE" && $item['answers'][4]['answer'] == $b['barcode']){
                $urun = new Product;
                $urun->urunAdi = $item['answers'][3]['answer'];
                $urun->barcode = $item['answers'][4]['answer'];
                $urun->resim = $item['answers'][9]['answer'];
                $urun->fiyat = $item['answers'][8]['answer'];
                $urunler[] = $urun;
            }
        }
    }
    return new SuccessDataResult($urunler,"Barcode found successfully");
    exit();
    
    
    return new ErrorDataResult(null,"Barcode does not exist in Table");
}


?>