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
        print_r($this->vars);
        return $this->setSuccess();
    }

    public function LoginAction(){

        return $this->setSuccess();
    }

    public function UploadimageAction(){
       //print_r($this->vars);

        $data = $_POST['image'];
        $name = $_POST['token'].'_'.time().'.png';

        $res = file_put_contents('./'.$name,$data);
        if($res)
            return $this->setSuccess();
        else
            return $this->setError('Something went wrong');


    }
}