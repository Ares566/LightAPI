<?php
require_once 'MainController.php';
/**
 * Class User
 * User: Renat Abaidulin
 * Date: 09.08.2019
 * Time: 15:19
 */

require_once API_PATH.'model/User.php';

class UserController extends MainController
{
    public function IndexAction()
    {
        return $this->setError('Wrong request');
    }

    public function RegisterAction()
    {
        if(!(array_key_exists('email',$_POST) && $_POST['email'] && Utility::checkEmail($_POST['email']))){
            return $this->setError('Invalid email address');
        }
        // email is valid
        try {
            $email = trim($_POST['email']);
            $password = mt_rand(10000, 99999);
            $oUser = User::addUser($email, $password);
        }catch (Exception $e) {
            throw $e;
        }
        // send registered message
        $body = '<b>Congratulations!</b><br/>You have successfully registered in service<br/>Your password:<b>'.$password.'</b>';
        Utility::sendEmail($oUser->email,'Registration in Service',$body);
        return $this->setSuccess(array('token'=>$oUser->token),'Pls check your email(and Spam folder) for your password.');
    }

    public function LoginAction()
    {
        return $this->setSuccess();
    }

    public function UploadimageAction(){

        if(!(
            array_key_exists('image',$_POST) &&
            array_key_exists('token',$_POST) &&
            $_POST['image'] && $_POST['token']
        ))
            return $this->setError('Image and/or Token are not specified');

        $data = $_POST['image'];
        $name = $_POST['token'].'_'.time().'.png';

        $res = file_put_contents('./'.$name,$data);
        if($res)
            return $this->setSuccess();
        else
            return $this->setError('Something went wrong');


    }
}