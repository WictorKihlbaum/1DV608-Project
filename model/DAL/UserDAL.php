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
	
	
	/*private function connectToServer() {
		
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
	
		return $con;	
	}*/
	
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
		
		// Hash the password so we don't store it as plain text in the Database.
		$hashedPassword = $this -> hashNewUserPassword($newUser -> getPassword());
		
		// Query to add the user in the Database.
		$query = 'INSERT INTO users (UserName, Password) VALUES ("'. $newUser -> getUserName() .'", "'. $hashedPassword .'")';	
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> close();
		}
		
		$con -> close();
		
		// Add new user to the local cache aswell.
		$this -> registeredUsersCache[] = $newUser;
	}
	
	public function connectToServerAndAddFavoriteGamesite($user, $favorite) {
	
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
		$query = 'UPDATE users SET FavoriteGamesite = "'. $favorite .'" WHERE UserName = "'. $user .'"';
			
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> close();
		}
		
		$con -> close();
	}
	
	public function getFavoriteGamesiteForLoggedInUser($user) {
		
		$favoriteSite = '';
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
		
		$query = 'SELECT FavoriteGamesite FROM users WHERE UserName = "'. $user .'"';
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> bind_result($favorite);
			
			while ($stmt -> fetch()) {
				
				$favoriteSite = $favorite;
    		}
			
			$stmt -> close();
		}
		
		$con -> close();
		
		return $favoriteSite;
	}
	
	private function hashNewUserPassword($password) {
		
		$hash = password_hash($password, PASSWORD_DEFAULT);
		
		return $hash;
	}
	
	public function getRegisteredUsers() {
		
		if ($this -> registeredUsersCache == null ||
			empty($this -> registeredUsersCache)) {
			
			$this -> connectToServerAndFetchUsers();
		}
	
		return $this -> registeredUsersCache;	
	}

}