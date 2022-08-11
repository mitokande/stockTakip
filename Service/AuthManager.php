<?php
require_once("IAuthService.php");
require_once("Entities/User.php");
require_once("Entities/CurrentUser.php");
require_once("ApiConfig.php");
class AuthManager implements IAuthService
{



    private function createToken($email) : array
    {
        $userToken = password_hash("JOTFORM_VERY_VERY_SECRET_KEY,${email}",PASSWORD_BCRYPT);
        $expiry = Date('Y-m-d h:i:s', strtotime('+14 days'));
        return [$userToken,$expiry];
    }
    public function verifyUserToken($token): User
    {
        $response = getApi()->getFormSubmissions("222212597595058");
        foreach ($response as $item)
        {
            if($item["answers"][9]["answer"] == $token)
            {
                $username = $item["answers"][5]["answer"];
                $email = $item["answers"][7]["answer"];
                $userToken = $item["answers"][9]["answer"];
                $shopName = $item["answers"][8]["answer"];
                $tokenExpiry = $item["answers"][11]["answer"];
                $userOrderId = $item["answers"][3]["answer"];
                $userStockId = $item["answers"][4]["answer"];

                $user = new User($username,$userToken,$email,$shopName,$tokenExpiry,$userOrderId,$userStockId);
                CurrentUser::$user = $user;
                return $user;
            }
        }
        throw new Exception("Your session has been expired");
    }

    public function currentUser(): User
    {
        return CurrentUser::$user;
    }

    public function login($username, $password)
    {
        $response = getApi()->getFormSubmissions("222212597595058");

        $result = $this->verifyUserAndPassword($response,$username,$password);
        if ($result[0])
        {
            CurrentUser::$user = $result[1];
        }
     //   CurrentUser::$user = new User();
        return $result;
    }


    private function checkUserExist($response,$username,$email) :bool
        {
        foreach ($response as $item) {

            if($item["answers"][5]["answer"] == $username )
            {
                echo json_encode("This username already registered");
                return false;
            }
            elseif ($item["answers"][7]["answer"] == $email)
            {
                echo json_encode("This email already registered");
                return false;
            }
        }
        return true;
    }


    public function register($username, $email, $password, $shopName) : array
    {
        $response = getApi()->getFormSubmissions("222212597595058");
        $result = $this->checkUserExist($response,$username,$email);
        $tokenItem = $this->createToken($email);
        $userOrderId = 5454564654565645;
        $userStockId = 545466544;
        if ($result)
        {
            $response = getApi()->createFormSubmission("222212597595058",[
                "3" => "5456454645645",
                "4" => "564566545656",
                "5" => $username,
                "6" => password_hash($password,PASSWORD_BCRYPT),
                "7" => $email,
                "8" => $shopName,
                "9" => $tokenItem[0],
                "11" => $tokenItem[1]
            ]);
            $user = new User($username,$tokenItem[0],$email,$shopName,$tokenItem[1],$userOrderId,$userStockId);
            CurrentUser::$user = $user;
            return [true,$user];
        }
        return [false,null];
    }

    private function verifyUserAndPassword($response,$username,$password)
    {
        foreach ($response as $item) {
            if($item["answers"][5]["answer"] == $username && password_verify($password,$item["answers"][6]["answer"]))
            {
                $email = $item["answers"][7]["answer"];
                $userToken = $item["answers"][9]["answer"];
                $shopName = $item["answers"][8]["answer"];
                $tokenExpiry = $item["answers"][11]["answer"];
                $userOrderId = $item["answers"][3]["answer"];
                $userStockId = $item["answers"][4]["answer"];

                $user = new User($username,$userToken,$email,$shopName,$tokenExpiry,$userOrderId,$userStockId);
                return [true,$user];
            }
        }
        return [false,null];
    }



}

