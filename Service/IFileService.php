<?php
require 'vendor/autoload.php';
require_once("Utilities/UUID/UUID.php");
require_once("Utilities/Result/DataResult.php");
interface IFileService
{
    function Upload($filename,$tempFileLocation) : DataResult;
}