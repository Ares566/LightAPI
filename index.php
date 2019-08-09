<?

	$data = $_POST['image'];
	$name = $_POST['token'].time().'.png';

	$res = file_put_contents('./'.$name,$data);
	if($res)
        echo "OK";
    else
        echo "ERR";
  