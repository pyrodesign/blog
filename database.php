<?php
	class Database {
		private $type;
		private $connection; //database connection
		private $result;  //result object;
		private $error; //error strings;
		private $prefix;
		
		function __CONSTRUCT() {
			$conf = new Configuration();
			$this->type = $conf->getDBType;
			if($conf->getDBType == "mysql") {
				$this->connection = new mysqli($conf->getDBHost,$ocnf->getDBuser(),$conf->getDBPass(),$conf->getDBDatabase());
				if ($mysqli->connect_error) {
					 throw new Exception('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
				}
			}
			$this->prefix = $conf->getDBPrefix();
		}
		
		/**
		gives a copy of the connection object
		@returns Object connection object
		**/
		public function getConnection() {
			return $this->connection;
		}
		
		/**
		return a copy of the result variable
		@return Object result object 
		**/
		public function getResult() {
			return $this->result;
		}
		
		public function escapeString($item) {
			if($this->type == "mysql") {
				return $this->connection->real_escape_string($item);
			}
		}
		
		/**
		perform a standard SQL query
		@param $sql String the query to be run
		@param $pre String a generic prefix to be replaced with proper prefix.  Defaults to #__
		**/
		public function query($sql,$pre='#__') {
			//replace the generic prefix with proper table prefix
			$sql = str_replace ($pre, $this->prefix, $sql); 
			$this->result = $connection->query($sql);
		}
		/**
		make a prepared statement to avoid SQL injection attacks
		@param $sql String the sql query
		@param $types the types for the sql statement
		@param ... list of fields to be put into the query
		**/
		public function preparedQuery($sql, $types) {
			if($this->type == "mysql") {
				$args = func_get_args();
				$stmt = $mysqli->prepare($sql);
				for($a = 2; a < count($args);$a++)
					$items[$a-2] = $stmt[$a];
				call_user_func_array(array($stmt, "bind_param"), $items);
				$stmt->execute();
				$this->result = $stmt->get_result();
			}
		}
		/**
		return an associative array from the result set
		@return array an array of fields
		**/
		public function fetchAssoc() {
			if($this->type == "mysql") {
				return $this->result->fetch_assoc();
			}
		}
	}
	