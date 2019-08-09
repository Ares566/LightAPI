<?
	//print_r($_POST);
	$data = $_POST['image'];
	$name = $_POST['token'].time().'.png';
	
	
	// list($type, $data) = explode(';', $data);
 //    list(, $data)      = explode(',', $data);
 //    $data = base64_decode($data);

	$res = file_put_contents('./'.$name,$data);
	if($res)
  	echo "OK";
  else
  	echo "ERR";
  