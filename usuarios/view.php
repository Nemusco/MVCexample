<?php
##KEYWORDS TO RENDER VIEWS 
$dictionary = array(
	"subtitle" => array(
		VIEW_SET_USER => "Create new user",
		VIEW_GET_USER => "Search an user",
		VIEW_EDIT_USER => "Modify an user",
		VIEW_DELETE_USER => "Delete an user"
	),
	"links_menu" => array(
		"VIEW_SET_USER" => MODULO.VIEW_SET_USER."/",
		"VIEW_GET_USER" => MODULO.VIEW_GET_USER."/",
		"VIEW_EDIT_USER" => MODULO.VIEW_EDIT_USER."/",
		"VIEW_DELETE_USER" => MODULO.VIEW_DELETE_USER."/"
		##THIS COMPLETES THE URL TO THE VIEW, THIS ADD "usuarios/get/ TO THE URL THAT MENU LINKS SEND"
	),
	"form_actions" => array(
		"SET" => MODULO.SET_USER."/",
		"GET" => MODULO.GET_USER."/",
		"EDIT" => MODULO.EDIT_USER."/",
		"DELETE" => MODULO.DELETE_USER."/"
		##THIS DOES THE SAME THAT LINKS_MENU ARRAY DOES
	)
);

function get_template( $form ){
	$file = $_SERVER["DOCUMENT_ROOT"]."/practicas/MVCexample/site_media/html/usuario_".$form."_usuario.html";
	$template = file_get_contents($file);
	return $template;
	##READS VIEW FILE AND RETURNS AS STRING
}

function render_dinamic_data( $data = array(), $html ){
	foreach( $data as $key => $value ) $html = str_replace("{".$key."}", $value, $html);
	return $html;
	##REPLACE ALL MATCHES AND RETURNS THE VIEW WITH CHANGES
}

function return_view( $view, $data = array() ){
	global $dictionary;
	$html = get_template("template"); ##GOT THE VIEW TO BE MODIFIED
	$html = str_replace("{subtitulo}",$dictionary["subtitle"][$view],$html);
	$html = str_replace("{formulario}",get_template($view),$html);
	$html = render_dinamic_data($dictionary["form_actions"],$html);
	$html = render_dinamic_data($dictionary["links_menu"],$html);
	$html = render_dinamic_data($data,$html);

	if( array_key_exists("name",$data) && array_key_exists("last_name", $data) && $view === VIEW_EDIT_USER ){
		$message = "EDITAR USUARIO ".$data["name"]." ".$data["last_name"];
	}
	else {
		if( array_key_exists("message", $data) ) $message = $data["message"];
		else $message = "User's data";
	}
	$html = str_replace("{message}",$message,$html);
	print($html);
}
?>