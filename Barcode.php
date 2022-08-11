<?php 
require_once("ApiConfig.php");
require_once("Product.php");


if(isset($_POST['barcode'])){
    echo checkBarcode($jotformAPI);
}


function checkBarcode($jotformAPI){
    $barcodeTable = $jotformAPI->getFormSubmissions("222211745912045");
    foreach($barcodeTable as $item){
        if($item['answers'][4]['answer'] == $_POST['barcode']){
            $urun = new Product;
            $urun->urunAdi = $item['answers'][3]['answer'];
            $urun->barcode = $item['answers'][4]['answer'];
            $urun->resim = $item['answers'][9]['answer'];
            $urun->fiyat = $item['answers'][8]['answer'];
            return json_encode($urun);
        }
    }
    return json_encode("Barcode does not exist in Table");
}

?>