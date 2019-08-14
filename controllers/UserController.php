<?php
require_once 'MainController.php';
/**
 * Class User
 * User: Renat Abaidulin
 * Date: 09.08.2019
 * Time: 15:19
 */


class UserController extends MainController
{
    public function IndexAction()
    {
        return $this->setError('Wrong request');
    }

    /**
     * Register new User by email
     * generate password and send it by mail
     * generate token and return it in JSON request
     *
     * @return array
     * @throws Exception
     */
    public function RegisterAction()
    {
        if(!(array_key_exists('email',$_POST) && $_POST['email'] && Utility::checkEmail($_POST['email']))){
            return $this->setError('Invalid email address');
        }
        // email is valid
        try {
            $email = trim($_POST['email']);
            // generate password
            $password = mt_rand(10000, 99999);
            $oUser = User::addUser($email, $password);
        }catch (Exception $e) {
            throw $e;
        }
        // send registered message
        $body = '<b>Congratulations!</b><br/>You have successfully registered in service<br/>Your password:<b>'.$password.'</b>';
        Utility::sendEmail($oUser->email,'Registration in Service',$body);
        // all ok return token
        return $this->setSuccess(array('token'=>$oUser->token),'Pls check your email(and Spam folder) for your password.');
    }

    /**
     * Login by email and password
     * return token if success
     *
     * @return array
     */
    public function LoginAction()
    {
        if(!(
            array_key_exists('email',$_POST) && trim($_POST['email']) &&
            array_key_exists('pass',$_POST) && trim($_POST['pass'])
        )){
            return $this->setError('Wrong credentials');
        }
        // try to get User by email
        $oUser = User::getUserByEmail(trim($_POST['email']));

        if(!$oUser)
            return $this->setError('Wrong credentials');

        // check if password correct
        if($oUser->password != md5(trim($_POST['pass']))){
            return $this->setError('Wrong password');
        }
        // update last login field
        $oUser->setLastLogin();

        // return token if it is
        return $this->setSuccess(array('token'=>$oUser->token));
    }

    public function GetimageAction(){
        if(!(array_key_exists('token',$_POST) && trim($_POST['token'])))
            throw new Exception('Token is not specified');
        $token = trim($_POST['token']);
        $payload = array('uri'=>'');
        //TODO: may be store it in DB?
        if(file_exists(API_PATH.'img/'.$token.'.png')){
            $payload['uri'] = Settings::$JSON_API_SERVER_URL.'/img/'.$token.'.png';
        }
        return $this->setSuccess($payload);
    }
    public function UploadimageAction(){

        if(!(
            array_key_exists('image',$_POST) &&
            array_key_exists('token',$_POST) &&
            $_POST['image'] && $_POST['token']
        ))
            throw new Exception('Image or Token are not specified');

        $data = $_POST['image'];
        $name = $_POST['token'].'.png';

        //TODO: may be store it in DB?
        $res = file_put_contents(API_PATH.'img/'.$name,$data);
        if($res)
            return $this->setSuccess();
        else
            return $this->setError('Something went wrong');


    }
}