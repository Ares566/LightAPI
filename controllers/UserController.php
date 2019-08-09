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
        return $this->setSuccess();
    }

    public function RegisterAction(){
        print_r($this->vars);
        return $this->setSuccess();
    }
}
