<?php
require 'vendor/autoload.php';
require_once("Utilities/UUID/UUID.php");
require_once("IAwsS3Service.php");
require_once("Utilities/Result/SuccessDataResult.php");
class AwsS3Manager implements IAwsS3Service
{

    private Aws\S3\S3Client $client;
    public function __construct()
    {
        $this->client = new Aws\S3\S3Client([
            'region' => 'eu-central-1',
            'version' => 'latest',
            'credentials' => [
                'key' => "AKIA2ZUBTTNJWUJXCUPN",
                'secret' => "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",
            ]
        ]);
    }

    function Upload($tempFileLocation): DataResult
    {
        $uuid = UUID();
        $result = $this->client->putObject([
            'Bucket' => 'jotform-intern',
            'Key' => "images/$uuid",
            'SourceFile' => $tempFileLocation
        ]);
        $imageUrl = $result->get("ObjectURL");
        return new SuccessDataResult($imageUrl,"Image has been uploaded successfully");
    }
}