<?php
namespace Service;
require_once("vendor/autoload.php");
require_once("ApiConfig.php");
require_once("Actions.php");

class AuthManager implements IAuthService
{
    private function createToken($email) : array
    {
        $userToken = password_hash("JOTFORM_VERY_VERY_SECRET_KEY,${email}",PASSWORD_BCRYPT);
        $expiry = Date('Y-m-d h:i:s', strtotime('+14 days'));
        return [$userToken,$expiry];
    }
    public function verifyUserToken($token) : \Utilities\Result\DataResult
    {
        $response = getApi()->getFormSubmissions("222212597595058");
        foreach ($response as $item)
        {
            if($item["answers"][9]["answer"] == $token)
            {
                $tokenExpiry = $item["answers"][11]["answer"];
                if ($tokenExpiry<=date("Y-m-d H:i:s"))
                {
                    return new \Utilities\Result\ErrorDataResult(null,"Your session has been expired");
                }
                $id = $item["id"];
                $username = $item["answers"][5]["answer"];
                $email = $item["answers"][7]["answer"];
                $userToken = $item["answers"][9]["answer"];
                $shopName = $item["answers"][8]["answer"];
                $userOrderId = $item["answers"][4]["answer"];
                $userStockId = $item["answers"][3]["answer"];

                $user = new \Entities\User($id,$username,$userToken,$email,$shopName,$tokenExpiry,$userOrderId,$userStockId);
                \Entities\CurrentUser::$user = $user;
                return new \Utilities\Result\SuccessDataResult($user,"Your token is valid");
            }
        }
        return new \Utilities\Result\ErrorDataResult(null,"Invalid Token");
    }

    public function currentUser(): \Entities\User
    {
        return \Entities\CurrentUser::$user;
    }

    public function login($username, $password) : \Utilities\Result\DataResult
    {
        $response = getApi()->getFormSubmissions("222212597595058");

        $result = $this->verifyUserAndPassword($response,$username,$password);

        if ($result->success)
        {
            $tokenResult = $this->createToken($result->data->getEmail());
            $result->data->setUserToken($tokenResult[0]);
            $result->data->setTokenExpiry($tokenResult[1]);
            $updatedTokenResult = $this->updateUserToken($result->data);
            \Entities\CurrentUser::$user = $updatedTokenResult->data;
            return new \Utilities\Result\SuccessDataResult($updatedTokenResult->data,"Logged in successfully");
        }
        \Entities\CurrentUser::$user = new \Entities\User("","","","","","","","");
        return new \Utilities\Result\ErrorDataResult(null,"Invalid Credentials");
    }


    private function checkUserExist($response,$username,$email) : \Utilities\Result\Result
        {
        foreach ($response as $item) {

            if($item['status'] == "ACTIVE"){
                if($item["answers"][5]["answer"] == $username )
                {
                    return new \Utilities\Result\ErrorResult("This username has already been registered");
                }
                elseif ($item["answers"][7]["answer"] == $email)
                {
                    return new \Utilities\Result\ErrorResult("This email has already been registered");
                }
            }
        }
        return new \Utilities\Result\SuccessResult("");
    }


    public function register($username, $email, $password, $shopName) : \Utilities\Result\DataResult
    {
        $response = getApi()->getFormSubmissions("222212597595058");
        $result = $this->checkUserExist($response,$username,$email);
        $tokenItem = $this->createToken($email);

        if ($result->success)
        {
            $response = getApi()->createFormSubmission("222212597595058",[
                "5" => $username,
                "6" => password_hash($password,PASSWORD_BCRYPT),
                "7" => $email,
                "8" => $shopName,
                "9" => $tokenItem[0],
                "11" => $tokenItem[1]
            ]);
            $jotformAPI = getApi();

            $stockFormId = cloneStockForm($jotformAPI);
            insertStockFormID($jotformAPI,$response['submissionID'],$stockFormId);

            $orderFormId = cloneOrderForm($jotformAPI);
            insertOrderFormID($jotformAPI,$response['submissionID'],$orderFormId);



            $user = new \Entities\User(null,$username,$tokenItem[0],$email,$shopName,$tokenItem[1],$orderFormId,$stockFormId);
            \Entities\CurrentUser::$user = $user;
            return new \Utilities\Result\SuccessDataResult($user,"You has been registered successfully!");
        }
        return new \Utilities\Result\ErrorDataResult(null,$result->message);
    }

    private function verifyUserAndPassword($response,$username,$password) : \Utilities\Result\DataResult
    {
        foreach ($response as $item) {

            if($item['status'] == "ACTIVE" && $item["answers"][5]["answer"] == $username &&  password_verify($password,$item["answers"][6]["answer"]))
            {
                $id = $item["id"];
                $email = $item["answers"][7]["answer"];
                $userToken = $item["answers"][9]["answer"];
                $shopName = $item["answers"][8]["answer"];
                $tokenExpiry = $item["answers"][11]["answer"];
                $userOrderId = $item["answers"][3]["answer"];
                $userStockId = $item["answers"][4]["answer"];

                $user = new \Entities\User($id,$username,$userToken,$email,$shopName,$tokenExpiry,$userOrderId,$userStockId);
                return new \Utilities\Result\SuccessDataResult($user,"Password verified");
            }
        }
        return new \Utilities\Result\ErrorDataResult(null,"Password couldn't have verified");
    }


    public function updateUserToken(\Entities\User $user): \Utilities\Result\DataResult
    {
        getApi()->editSubmission($user->id,array(
            "9" => $user->userToken,
            "11" => $user->tokenExpiry
        ));
        return  new \Utilities\Result\SuccessDataResult($user,"New token has been created successfully");
    }
}

