<?php

class UserDAL {
	
	private $host = '127.0.0.1';
	private $port = 8889;
	private $socket = '';
	private $user = 'root';
	private $password = 'root';
	private $dbname = 'mylocaldb';
	
	private $registeredUsersCache = array();
	
	
	public function __construct() {
	
		$this -> connectToServerAndFetchUsers(); 	
	}
	
	
	public function connectToServerAndFetchUsers() {
	
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
		
		$query = 'SELECT userName, password FROM users';
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> bind_result($userName, $password);
			
			while ($stmt -> fetch()) {
				
				$registeredUser = new UserModel($userName, $password);
				$this -> registeredUsersCache[] = $registeredUser;
    		}
				
			$stmt -> close();
		}
		
		$con -> close();
	}
	
	public function getRegisteredUsers() {
	
		return $this -> registeredUsersCache;	
	}
	
	public function connectToServerAndAddUser($newUser) {
	
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
			
		$query = 'INSERT INTO users (userName, password) VALUES ("'. $newUser -> getUserName() .'", "'. $newUser -> getPassword() .'")';	
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> close();
		}
		
		$con -> close();
	}
}