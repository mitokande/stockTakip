<?php 
require_once("ApiConfig.php");
require_once("Service/AuthManager.php");

require_once("Entities/Product.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
require_once("Utilities/Result/SuccessResult.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/ErrorDataResult.php");
require_once("Utilities/Result/SuccessDataResult.php");



if($barcode != null){
    $authManager = new AuthManager();
    if(!empty(getallheaders()['token'])){
        $result = $authManager->verifyUserToken(getallheaders()['token']);
    }
    if (isset($result) && $result->success)
    {
        $user = $result->data;
        $orderFormId = $user->getUserOrderId();
        // echo $orderFormId;
        echo json_encode($orderController->addOrder(getApi(),$orderFormId,$orderInput));
        exit();
    }
    if(!empty($barcode['barcode'])){
        echo json_encode(checkBarcode(getApi(),$barcode['barcode']));
    }
}


function addBarcode($jotformAPI,$barcode){
//not yet implemented
}

function checkBarcode($jotformAPI,$barcode): DataResult
{
    $barcodeTable = $jotformAPI->getFormSubmissions("222211745912045");
    foreach($barcodeTable as $item){
        if($item['answers'][4]['answer'] == $barcode){
            $urun = new Product;
            $urun->urunAdi = $item['answers'][3]['answer'];
            $urun->barcode = $item['answers'][4]['answer'];
            $urun->resim = $item['answers'][9]['answer'];
            $urun->fiyat = $item['answers'][8]['answer'];
            return new SuccessDataResult($urun,"Barcode found successfully");
        }
    }
    return new ErrorDataResult(null,"Barcode does not exist in Table");
}

?>