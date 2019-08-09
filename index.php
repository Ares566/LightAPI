<?
    ini_set('error_reporting',1);
    error_reporting(E_ALL);

    require_once 'model/Settings.php';
    require_once 'model/Utility.php';
    require_once 'Controllers/Router.php';


    define('API_PATH',$_SERVER['DOCUMENT_ROOT'].'/');

    $oRouter = new Router();
    //$oRouter->addRoute('/userinfo/getinfo/','User','Index');
    try{
        $result = $oRouter->route();
        echo $result;
    }catch (Exception $e){
        //TODO: logging exception
        echo json_encode(array('result'=>'ERR','message'=>$e->getMessage()));
    }


    exit;

	$data = $_POST['image'];
	$name = $_POST['token'].time().'.png';

	$res = file_put_contents('./'.$name,$data);
	if($res)
        echo "OK";
    else
        echo "ERR";
  