<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Token ,Origin, X-Requested-With, Content-Type, Accept, Authorization');
require_once("ApiConfig.php");
require_once("AwsTest.php");



$barcodeJSON = file_get_contents('php://input');
$barcode = json_decode($barcodeJSON, TRUE); //convert JSON
header("Content-Type: application/json; charset=utf-8");

if(isset($_POST['barcode'])){
    $authManager = new Service\AuthManager();
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


function addBarcode($jotformAPI,$barcode): \Utilities\Result\DataResult{
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
    return new \Utilities\Result\SuccessDataResult($result,"New Barcode added to the database successfuly");
}

function checkBarcode($jotformAPI,$barcode): \Utilities\Result\DataResult
{
    $barcodeTable = $jotformAPI->getFormSubmissions("222211745912045");
    // if(count($barcode)== 1){
    //     $barcode = array($barcode);
    // }
    $urunler = [];
    foreach($barcode as $b){
        foreach($barcodeTable as $item){
            if($item['status'] == "ACTIVE" && $item['answers'][4]['answer'] == $b['barcode']){
                $urun = new Entities\Product;
                $urun->urunAdi = $item['answers'][3]['answer'];
                $urun->barcode = $item['answers'][4]['answer'];
                $urun->resim = $item['answers'][9]['answer'];
                $urun->fiyat = $item['answers'][8]['answer'];
                $urunler[] = $urun;
            }
        }
    }
    return new \Utilities\Result\SuccessDataResult($urunler,"Barcode found successfully");
    exit();


    return new \Utilities\Result\ErrorDataResult(null,"Barcode does not exist in Table");
}


?>