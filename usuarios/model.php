<?php  
require_once($_SERVER["DOCUMENT_ROOT"]."/practicas/MVCexample/core/db_abstract_model.php");

class Users extends DBAbstractModel {
	public $name;
	public $email;
	public $last_name;
	public $pw;
	public $message;
	protected $id;

	public function get( $data = array() ){
		if( array_key_exists("email",$data) ){
			$email = $data["email"];
			$this->query = "
			SELECT id,name,last_name,email,password FROM Users WHERE email='$email';
			";

			$this->get_results_from_query();
		}

		if( count($this->rows) === 1 ){
			foreach($this->rows[0] as $property => $value) $this->$property = $value;
			$this->message = "User found";
		}
		else
			$this->message = "User not found";
	} 

	public function set( $data = array() ){
		if( array_key_exists("email",$data) ){
			$this->get( $data );
			if( $this->message === "User not found" ){
				foreach( $data as $key => $value ) $$key = $value;
				$this->query = "
				INSERT INTO Users(name,last_name,email,password) VALUES ('$name','$last_name','$email','$password');
				";
				$this->execute_single_query();
				$this->message = "User added successfully";
			}
			else
				$this->message = "User already exists";
		}
		else
			$this->message = "It was impossible to add";
	}

	public function edit( $data = array() ){
		foreach( $data as $key => $value ) $$key = $value;
		$this->query = "
		UPDATE Users SET name='$name',last_name='$last_name' WHERE email='$email';
		";
		$this->execute_single_query();
		$this->message = "User was modified";
	}

	public function delete( $data = array() ){
		if( array_key_exists("email",$data) ){
			$email = $data["email"];
			$this->query= "
			DELETE FROM Users WHERE email='$email';
			";
			$this->execute_single_query();
			$this->message = "User deleted";
		}
	}

	public function __construct(){
		$this->db = "mvc_example";
	}

	public function __destruct(){
		unset($this->db);
	}
}
?>