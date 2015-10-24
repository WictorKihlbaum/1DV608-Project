<?php

class UserDAL {
	
	// Local DB.
	/*private $host = '127.0.0.1';
	private $port = 8889;
	private $socket = '';
	private $user = 'root';
	private $password = 'root'; // one4one
	private $dbname = 'RegisteredUsers';*/
	
	// Public DB.
	private $host = 'eu-cdbr-azure-north-d.cloudapp.net';
	private $port = 3306;
	private $socket = '';
	private $user = 'bd59d7069aef53';
	private $password = '6d5d241f';
	private $dbname = 'acsm_9268280c21a7845';
	
	private $registeredUsersCache = array();
	private $rssCache = array();
	
	
	public function __construct() {
	
		$this -> connectToServerAndFetchUsers();
		$this -> connectToServerAndFetchRSSFeeds();	
	}
	
	public function connectToServerAndFetchRSSFeeds() {
		
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
		
		$query = 'SELECT SiteName, RssLink FROM rss';
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> bind_result($siteName, $rssLink);
			
			while ($stmt -> fetch()) {
				
				$rss = new RssModel($siteName, $rssLink);
				$this -> rssCache[] = $rss;
    		}
				
			$stmt -> close();
		}
		
		$con -> close();
	}

	public function connectToServerAndFetchUsers() {
	
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
		
		$query = 'SELECT UserName, Password FROM users';
		
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
	
	public function connectToServerAndAddUser($newUser) {
	
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
			
		$query = 'INSERT INTO users (UserName, Password) VALUES ("'. $newUser -> getUserName() .'", "'. $newUser -> getPassword() .'")';	
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> close();
		}
		
		$con -> close();
	}
	
	public function getRegisteredUsers() {
	
		return $this -> registeredUsersCache;	
	}
	
	public function getRss() {
	
		return $this -> rssCache;	
	}
}