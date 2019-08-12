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

    public function RegisterAction(){
        return $this->setSuccess();
    }

    public function LoginAction(){
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