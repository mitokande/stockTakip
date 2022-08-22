<?php
namespace Service;
require_once("vendor/autoload.php");

use Utilities\Result\DataResult;


interface IFileService
{
    function Upload($filename,$tempFileLocation) : DataResult;
}