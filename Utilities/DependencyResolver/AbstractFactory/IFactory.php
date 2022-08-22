<?php
namespace Utilities\DependencyResolver\AbstractFactory;

use Service\IAuthService;
use Service\IFileService;

require_once("vendor/autoload.php");

interface IFactory
{
    public function createAuthManager(): IAuthService;

    public function createFileService() : IFileService;
}