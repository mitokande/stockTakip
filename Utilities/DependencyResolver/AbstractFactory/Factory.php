<?php
require_once("Utilities/DependencyResolver/AbstractFactory/IFactory.php");
require_once("Service/AuthManager.php");
require_once("Service/AwsS3Manager.php");
require_once("Service/IAuthService.php");
require_once("Service/IFileService.php");

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