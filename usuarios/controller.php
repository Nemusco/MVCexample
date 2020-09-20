<?php 
require_once("constants.php");
require_once("model.php");
require_once("view.php");

function handler(){
	##THE ROUTE CONTROLLER
	$event = VIEW_GET_USER;
	$uri = $_SERVER["REQUEST_URI"]; ##GET THE URL SET FOR EXAMPLE practicas/MVCexample/usuarios/edit
	$requests = array(
		SET_USER,GET_USER,EDIT_USER,DELETE_USER,
		VIEW_GET_USER,VIEW_SET_USER,VIEW_EDIT_USER,VIEW_DELETE_USER
	);

	foreach( $requests as $request ){
		$uri_request = MODULO.$request."/";
		##CONSTRUCT THE ROUTE usuarios/get FOR EXAMPLE
		if( strpos($uri,$uri_request) ) $event = $request;
	}
	$user_data = helper_user_data();
	$user = set_obj();

	switch( $event ){
		##EVALUATE THE VALUE OF THE REQUEST MADE
		case SET_USER:
		$user->set($user_data); ##EXECUTE THE CORRESPONDING ACTION
		$data = array("message" => $user->message); ##DATA WILL EVER BE THE ARRAY WE SEND TO VIEW
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
		##WHEN WE SEND A GET REQUEST, CONTROLLER ASSUMES WE ALREADY SENT THE EMAIL TO FIND AN USER
		##SO AUTOMATICALLY SHOWS EDIT VIEW WITH DATA RETURNED FOR GET METHOD
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
		##ONCE WE SEND THE UPDATED INFO THE CONTROLLER WILL SHOW GET VIEW
		##THIS WORKS SO BECAUSE LINKS MENU JUST HAS ONE LINK FOR GET AND EDIT ACTION
		break;

		default: return_view($event);
	}
}

function set_obj(){
	##JUST CREATE A NEW Users INSTACE
	$obj = new Users();
	return $obj;
}

function helper_user_data(){
	$user_data = array();
	##CATCH INFO WAS SENT BY FORMS 
	if( !empty($_POST) ){
		##SAVE EACH FIELD SENT BY POST ONE BY ONE
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

handler(); ##THE PROGRAM STARTS
?>