<?php  
require_once("constants.php");
require_once("model.php");
require_once("view.php");

function handler(){
	$event = VIEW_GET_USER;
	$uri = $_SERVER["REQUEST_URI"];
	$requests = array(
		SET_USER,GET_USER,EDIT_USER,DELETE_USER,
		VIEW_GET_USER,VIEW_SET_USER,VIEW_EDIT_USER,VIEW_DELETE_USER
	);

	foreach( $requests as $request ){
		$uri_request = MODULO.$request."/";
		if( strpos($uri,$uri_request) ) $event = $request;
	}
	$user_data = helper_user_data();
	$user = set_obj();

	switch( $event ){
		case SET_USER:
		$user->set($user_data);
		$data = array("message" => $user->message);
		return_view(VIEW_SET_USER,$data);
		break;

		case GET_USER:
		$user->get($user_data);
		$data = array(
			"name" => $user->name,
			"last_name" => $user->last_name,
			"email" => $user->email
		);
		return_view(VIEW_EDIT_USER,$data);
		break;

		case DELETE_USER:
		$user->delete($user_data);
		$data = array("message" => $user->message);
		return_view(VIEW_DELETE_USER,$data);
		break;

		case EDIT_USER:
		$user->edit($user_data);
		$data = array("message" => $user->message);
		return_view(VIEW_GET_USER,$data);
		break;

		default: return_view($event);
	}
}

function set_obj(){
	$obj = new Users();
	return $obj;
}

function helper_user_data(){
	$user_data = array();

	if( !empty($_POST) ){
		if( array_key_exists("name", $_POST) ) $user_data["name"] = $_POST["name"];
		if( array_key_exists("last_name",$_POST) ) $user_data["last_name"] = $_POST["last_name"];
		if( array_key_exists("email",$_POST) ) $user_data["email"] = $_POST["email"];
		if( array_key_exists("password",$_POST) ) $user_data["password"] = $_POST["password"];
	}
	else if( !empty($_GET) ){
		if( array_key_exists("email",$_GET) ) $user_data["email"] = $_GET["email"]; 
	}
	return $user_data;
}

handler();
?>