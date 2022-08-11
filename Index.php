<?php 
require_once("ApiConfig.php");
require_once("AddStock.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Register User
    <form method="post">
        Username: <input type="text" name="username"><br>
        Password: <input type="text" name="password"><br>
        Email: <input type="text" name="email">
        <input type="submit" name="registerUser" value="Kullanıcı Ekle">
    </form>
    <hr>
    <form method="post">
        Magaza Adı:<input type="text" name="ad"><br>
        Email:<input type="text" name="email"><br>
        Ürün Adı:<input type="text" name="urunAdi"><br>
        Barcode:<input type="text" name="barcode"><br>
        Stok Adeti: <input type="text" name="stok"><br>
        Birim Fiyatı: <input type="text" name="fiyat"><br>
        Resim:<input type="text" name="resim">
        <input type="submit" name="addStock" value="Stok Ekle">
    </form>
</body>
</html>