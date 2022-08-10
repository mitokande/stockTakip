<?php
require_once("ApiConfig.php");
class AuthManager implements IAuthService
{
    public function verifyUserToken($token)
    {
        $response = $jotformAPI->getFormSubmissions("222212597595058");
        foreach ($response as $item)
        {
            if($item["answers"][9]["answer"] == $token)
            {
                return [true,$item["answers"][9]["answer"]];
            }
        }
        throw new Exception("Your session has been expired");
    }
}

