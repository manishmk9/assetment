<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST ,OPTIONS, PUT');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once "classes_file.php";
$db = new Database();
$book = new Booking();
$request = json_decode(file_get_contents('php://input'));
if(isset($request) && !empty($request))
{
	switch($request->action)
	{
		case "Details": 
				$book->data = $request; 
				$res = $book->details();
				echo json_encode($res);
				break;
		case "Book": 
				$book->data = $request; 
				$res = $book->add();
				echo json_encode($res);
				break;					
		default :
				$res = $db->responsehandler(0,array(),"Invalid API");
				echo json_encode($res);
	}
}
else
{
	$res = $db->responsehandler(0,array(),"Invalid API");
	echo json_encode($res);
}
?>