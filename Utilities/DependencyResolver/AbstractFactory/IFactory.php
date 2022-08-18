<?php
require_once("Service/IAuthService.php");

interface IFactory
{
    public function createAuthManager(): IAuthService;

    public function createFileService() : IFileService;
}