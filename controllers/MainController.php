<?php
/**
 * Main Controller
 *
 * User: Renat Abaidulin
 * Date: 09.08.2019
 * Time: 15:20
 */

abstract class MainController
{
    protected $jAnswer = array('result' => "OK", "payload" => array(), "message" => '');

    abstract public function IndexAction();

    function __construct($vars = null)
    {
        $this->vars = $vars;
        $this->dba = DB::getAdaptor();
    }

    public function __call($name, $arguments)
    {
        return $this->setError('Invalid request '.$name);
    }

    protected function setError($msg)
    {
        $this->jAnswer['result'] = "ERR";
        $this->jAnswer['message'] = $msg;
        return $this->jAnswer;
    }
    protected function setSuccess($payload=array(),$msg='')
    {
        $this->jAnswer['result'] = "OK";
        $this->jAnswer['payload'] = $payload;
        $this->jAnswer['message'] = $msg;
        return $this->jAnswer;
    }
}
