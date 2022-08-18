<?php
require_once("IAuthService.php");
require_once("Actions.php");
require_once("Entities/User.php");
require_once("Entities/CurrentUser.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
require_once("Utilities/Result/SuccessResult.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/ErrorDataResult.php");
require_once("Utilities/Result/ErrorResult.php");
require_once("Utilities/Result/SuccessDataResult.php");
require_once("Utilities/DependencyResolver/Singleton.php");

require_once("ApiConfig.php");
class AuthManager implements IAuthService
{
    private function createToken($email) : array
    {
        $userToken = password_hash("JOTFORM_VERY_VERY_SECRET_KEY,${email}",PASSWORD_BCRYPT);
        $expiry = Date('Y-m-d h:i:s', strtotime('+14 days'));
        return [$userToken,$expiry];
    }
    public function verifyUserToken($token) : DataResult
    {
        $response = getApi()->getFormSubmissions("222212597595058");
        foreach ($response as $item)
        {
            if($item["answers"][9]["answer"] == $token)
            {
                $tokenExpiry = $item["answers"][11]["answer"];
                if ($tokenExpiry<=date("Y-m-d H:i:s"))
                {
                    return new ErrorDataResult(null,"Your session has been expired");
                }
                $id = $item["id"];
                $username = $item["answers"][5]["answer"];
                $email = $item["answers"][7]["answer"];
                $userToken = $item["answers"][9]["answer"];
                $shopName = $item["answers"][8]["answer"];
                $userOrderId = $item["answers"][4]["answer"];
                $userStockId = $item["answers"][3]["answer"];

                $user = new User($id,$username,$userToken,$email,$shopName,$tokenExpiry,$userOrderId,$userStockId);
                CurrentUser::$user = $user;
                return new SuccessDataResult($user,"Your token is valid");
            }
        }
        return new ErrorDataResult(null,"Invalid Token");
    }

    public function currentUser(): User
    {
        return CurrentUser::$user;
    }

    public function login($username, $password) : Result
    {
        $response = getApi()->getFormSubmissions("222212597595058");

        $result = $this->verifyUserAndPassword($response,$username,$password);

        if ($result->success)
        {
            $tokenResult = $this->createToken($result->data->getEmail());
            $result->data->setUserToken($tokenResult[0]);
            $result->data->setTokenExpiry($tokenResult[1]);
            $updatedTokenResult = $this->updateUserToken($result->data);
            CurrentUser::$user = $updatedTokenResult->data;
            return new SuccessDataResult($updatedTokenResult->data,"Logged in successfully");
        }
        CurrentUser::$user = new User("","","","","","","","");
        return new ErrorDataResult(null,"Invalid Credentials");
    }


    private function checkUserExist($response,$username,$email) :Result
        {
        foreach ($response as $item) {

            if($item['status'] == "ACTIVE"){
                if($item["answers"][5]["answer"] == $username )
                {
                    return new ErrorResult("This username has already been registered");
                }
                elseif ($item["answers"][7]["answer"] == $email)
                {
                    return new ErrorResult("This email has already been registered");
                }
            }
        }
        return new SuccessResult("");
    }


    public function register($username, $email, $password, $shopName) : DataResult
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



            $user = new User(null,$username,$tokenItem[0],$email,$shopName,$tokenItem[1],$orderFormId,$stockFormId);
            CurrentUser::$user = $user;
            return new SuccessDataResult($user,"You has been registered successfully!");
        }
        return new ErrorDataResult(null,$result->message);
    }

    private function verifyUserAndPassword($response,$username,$password) : DataResult
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

                $user = new User($id,$username,$userToken,$email,$shopName,$tokenExpiry,$userOrderId,$userStockId);
                return new SuccessDataResult($user,"Password verified");
            }
        }
        return new ErrorDataResult(null,"Password couldn't have verified");
    }


    public function updateUserToken(User $user): DataResult
    {
        getApi()->editSubmission($user->id,array(
            "9" => $user->userToken,
            "11" => $user->tokenExpiry
        ));
        return  new SuccessDataResult($user,"New token has been created successfully");
    }
}

