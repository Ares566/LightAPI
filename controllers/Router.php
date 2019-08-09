<?php
/**
 * Routing routines
 * User: Renat Abaidulin
 * Date: 09.08.2019
 * Time: 13:50
 */


class Router
{
    private $aRouts = array();

    /**
     * Add Route if and when needs to hide inner logic
     *
     * @param string $fromurl
     * @param string $tocontroller
     * @param string $toaction
     */
    public function addRoute($fromurl="/",$tocontroller="Main",$toaction="Index")
    {
        $clearURL = trim($fromurl,"/");
        $this->aRouts[$clearURL] = array('controller'=>$tocontroller,'action'=>$toaction);
    }

    /**
     * Pass action to the desired class -> method
     *
     * @throws Exception
     */
    public function route()
    {
        $aParsedURI = parse_url($_SERVER['REQUEST_URI']);
        $clearURL = trim($aParsedURI['path'],"/");
        if(array_key_exists($clearURL,$this->aRouts)){
            $controller = $this->aRouts[$clearURL]['controller'];
            $action = $this->aRouts[$clearURL]['action'];
        }else{
            list($controller,$action) = explode('/',trim($aParsedURI['path'],"/"));
            $controller = ucwords($controller);
            $action = ucwords($action);
        }

        if(!$controller){
            throw new Exception("Controller not specified");
        }

        $aVars = Utility::query2Array($aParsedURI['query']);

        if(!$action)
            $action = 'Index';

        try{
            if(!file_exists(API_PATH.'/controllers/'.$controller.'Controller.php'))
                throw new Exception("Controller '$controller' not found");

            include_once API_PATH.'/controllers/'.$controller.'Controller.php';
            $rc = new ReflectionClass($controller.'Controller');
            $instance = $rc->newInstanceArgs(array($aVars));
            return $instance->{$action.'Action'}();
        }catch (Exception $e) {
            throw $e;
        }
    }
}
