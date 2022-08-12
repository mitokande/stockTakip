<?php 
require_once("ApiConfig.php");
require_once("Entities/Product.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
require_once("Utilities/Result/SuccessResult.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/ErrorDataResult.php");
require_once("Utilities/Result/SuccessDataResult.php");

if(isset($_POST['barcode'])){
    echo json_encode(checkBarcode(getApi(),$_POST['barcode']));
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