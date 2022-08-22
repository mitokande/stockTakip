<?php
namespace Service;
require_once("vendor/autoload.php");

use Aws\S3\S3Client;
use Dotenv\Dotenv;
use Utilities\Result\DataResult;
use Utilities\Result\SuccessDataResult;

class AwsS3Manager implements IFileService
{

    private S3Client $client;
    public function __construct()
    {

        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
        $dotenv->load();

        $region =  $_ENV["REGION"];
        $version =  $_ENV["VERSION"];
        $secretKey =  $_ENV["SECRET_KEY"];
        $accessKey=  $_ENV["ACCESS_KEY"];


        $this->client = new S3Client([
            'region' => $region,
            'version' => $version,
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey,
            ]
        ]);
    }

    function Upload($filename,$tempFileLocation): DataResult
    {
        $uuid = UUID();
        $result = $this->client->putObject([
            'Bucket' => 'jotform-intern',
            'Key' => "images/$uuid+$filename",
            'SourceFile' => $tempFileLocation
        ]);
        $imageUrl = $result->get("ObjectURL");
        getenv("");
        return new SuccessDataResult($imageUrl,"Image has been uploaded successfully");
    }
}