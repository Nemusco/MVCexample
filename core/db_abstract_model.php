<?php  
abstract class DBAbstractModel {
	private static $host = "localhost";
	private static $user = "root";
	private static $password = "";
	protected $db = "mydb";
	protected $query;
	protected $rows = array();
	private $conn;
	public $message = "Done";

	abstract protected function get();
	abstract protected function set();
	abstract protected function edit();
	abstract protected function delete();

	#CREATE A CONNECTION
	private function open_connection(){
		$this->conn = new mysqli(self::$host,self::$user,self::$password,$this->db);
	}

	#CLOSE THE CONNECTION
	private function close_connection(){
		$this->conn->close();
	}

	#MAKE SIMPLE QUERIES LIKE INSERT, UPDATE, DELETE
	protected function execute_single_query(){
		if( !empty($_POST) ){
			self::open_connection();
			$this->conn->query($this->query);
			self::close_connection();
		}
		else
			$this->message = "METHOD FORBIDDEN";
	}

	#MAKE SELECT QUERY
	protected function get_results_from_query(){
		self::open_connection();
		$results = $this->conn->query($this->query);
		while( $this->rows[] = $results->fetch_assoc() );	#SAVE INTO ROWS EACH RETURNED ROW 
		$results->close();
		self::close_connection();
		array_pop($this->rows);
	}
}

?>