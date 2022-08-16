<?php 
require_once("ApiConfig.php");
// require_once("Barcode.php");
require_once("Entities/Product.php");
require_once("Service/AuthManager.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
require_once("Utilities/Result/SuccessResult.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/ErrorDataResult.php");
require_once("Utilities/Result/SuccessDataResult.php");

class StockController{
function checkBarcode($jotformAPI,$barcode): DataResult
{
    $barcodeTable = $jotformAPI->getFormSubmissions("222211745912045");
    
    foreach($barcodeTable as $item){
        if($item['status'] == "ACTIVE" && $item['answers'][4]['answer'] == $barcode){
            $urun = new Product;
            $urun->urunAdi = $item['answers'][3]['answer'];
            $urun->barcode = $item['answers'][4]['answer'];
            $urun->resim = $item['answers'][9]['answer'];
            $urun->fiyat = $item['answers'][8]['answer'];
            
        }
    }
    return new SuccessDataResult($urun,"Barcode found successfully");
    exit();
    
    
    return new ErrorDataResult(null,"Barcode does not exist in Table");
}

function addStock($jotformAPI,$stockFormID,$stockInput): DataResult
{

    foreach($stockInput as $stock){
        $image = $this->checkBarcode($jotformAPI,$stock['barcode'])->data->resim;
        
        // print_r($image);
        $authManager = new AuthManager();
        $user = $authManager->verifyUserToken(getallheaders()['Token'])->data;
    
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





function getStocks($stockFormId) : DataResult
{
    $stockTable = getApi()->getFormSubmissions($stockFormId);
    $stocks = [];
    foreach($stockTable as $item){
        if($item['status'] == "ACTIVE"){
            $urun = new Product;
            $urun->urunAdi = $item['answers'][5]['answer'];
            $urun->barcode = $item['answers'][6]['answer'];
            $urun->resim = $item['answers'][14]['answer'];
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