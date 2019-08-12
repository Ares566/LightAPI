<?
    // Headers for Cross-Origin Resource Sharing (CORS)
    // TODO: move * to Settings
    header("Access-Control-Allow-Orgin: *");
    header("Access-Control-Allow-Methods: *");

    // JSON API server
    header("Content-Type: application/json");

    // TODO: remove after debug
//    ini_set('error_reporting',1);
//    error_reporting(E_ALL);




    define('API_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
    include_once 'include.php';

    $oRouter = new Router();

    //Add Route rules if it needs
    //$oRouter->addRoute('/userinfo/getinfo/','User','Index');

    try{
        $result = $oRouter->route();
        echo json_encode($result);
    }catch (Exception $e){
        //TODO: logging exception
        //FIXME: private exceptions)
        echo json_encode(array('result'=>'ERR','message'=>$e->getMessage()));
    }
