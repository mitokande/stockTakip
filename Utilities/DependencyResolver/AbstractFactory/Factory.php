<?php
namespace Utilities\DependencyResolver\AbstractFactory;

use Service\AuthManager;
use Service\AwsS3Manager;
use Service\IAuthService;
use Service\IFileService;

require_once("vendor/autoload.php");


class Factory implements IFactory
{
    public function createAuthManager(): IAuthService
    {
        return new AuthManager();
    }

    public function createFileService(): IFileService
    {
        return new AwsS3Manager();
    }

    public static function getInstance(): self
    {
        return new Factory();
    }


}