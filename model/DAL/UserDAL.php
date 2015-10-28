<?php

class UserDAL {
	
	// Public DB.
	private $host = 'eu-cdbr-azure-north-d.cloudapp.net';
	private $port = 3306;
	private $socket = '';
	private $user = 'bd59d7069aef53';
	private $password = '6d5d241f';
	private $dbname = 'acsm_9268280c21a7845';
	
	private $registeredUsersCache = array();
	
	
	private function connectToServerAndFetchUsers() {
	
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
		$query = 'SELECT UserName, Password FROM users';
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> bind_result($userName, $password);
			
			while ($stmt -> fetch()) {
				// Save all DB-content to a "cache-array".
				$registeredUser = new UserModel($userName, $password);
				$this -> registeredUsersCache[] = $registeredUser;
    		}
				
			$stmt -> close();
		}
		
		$con -> close();
	}
	
	public function connectToServerAndAddUser($newUser) {
	
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
		
		// Encode the password so we don't store it as plain text in the Database.
		$encodedPassword = $this -> encodeNewUserPassword($newUser -> getPassword());
		
		// Query to add the user in the Database.
		$query = 'INSERT INTO users (UserName, Password) VALUES ("'. $newUser -> getUserName() .'", "'. $encodedPassword .'")';	
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> close();
		}
		
		$con -> close();
		
		// Add new user to the local cache aswell.
		$this -> registeredUsersCache[] = $newUser;
	}
	
	private function encodeNewUserPassword($password) {
		
		$cost = 10;
		/* Create a random salt. "Salt" is random data that is used as an additional 
		   input to a function that hashes a password. */
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		// Prefix information about the hash so PHP knows how to verify it later.
		$salt = sprintf('$2a$%02d$', $cost) . $salt;
		$hash = crypt($password, $salt);
		
		return $hash;
	}
	
	public function getRegisteredUsers() {
		
		if ($this -> registeredUsersCache == null) {
			
			$this -> connectToServerAndFetchUsers();
		}
	
		return $this -> registeredUsersCache;	
	}

}