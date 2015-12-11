<?php

class UserDAL {
	
	private $registeredUsersCache = array();
	
	
	private function connectToServerAndFetchUsers() {
		
		$databaseInfo = new DatabaseInfoModel();
	
		$con = new mysqli(
			$databaseInfo -> getHost(), 
			$databaseInfo -> getUser(), 
			$databaseInfo -> getPassword(), 
			$databaseInfo -> getDatabaseName(), 
			$databaseInfo -> getPort(), 
			$databaseInfo -> getSocket()
		) 
		or die ('Could not connect to the database server' . mysqli_connect_error());
		
		if ($stmt = $con -> prepare($databaseInfo -> getUserCredentialsStoredProcedure())) {
			
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
	
		$databaseInfo = new DatabaseInfoModel();
	
		$con = new mysqli(
			$databaseInfo -> getHost(), 
			$databaseInfo -> getUser(), 
			$databaseInfo -> getPassword(), 
			$databaseInfo -> getDatabaseName(), 
			$databaseInfo -> getPort(), 
			$databaseInfo -> getSocket()
		) 
		or die ('Could not connect to the database server' . mysqli_connect_error());
		
		// Hash the password so we don't store it as plain text in the Database.
		$hashedPassword = $this -> hashNewUserPassword($newUser -> getPassword());	
		
		if ($stmt = $con -> prepare(
				$databaseInfo -> getAddNewUserStoredProcedure() . 
				'("' . $newUser -> getUserName() . '","' . $hashedPassword .'")')) {
			
			$stmt -> execute();
			$stmt -> close();
		}
		
		$con -> close();
		
		// Add new user to the local cache aswell.
		$this -> registeredUsersCache[] = $newUser;
	}
	
	public function connectToServerAndAddFavoriteGamesite($user, $favorite) {
	
		$databaseInfo = new DatabaseInfoModel();
	
		$con = new mysqli(
			$databaseInfo -> getHost(), 
			$databaseInfo -> getUser(), 
			$databaseInfo -> getPassword(), 
			$databaseInfo -> getDatabaseName(), 
			$databaseInfo -> getPort(), 
			$databaseInfo -> getSocket()
		) 
		or die ('Could not connect to the database server' . mysqli_connect_error());
			
		if ($stmt = $con -> prepare(
				$databaseInfo -> getUpdateFavoriteGamesiteStoredProcedure() . 
				'("'.$user.'","'.$favorite.'")')) {
			
			$stmt -> execute();
			$stmt -> close();
		}
		
		$con -> close();
	}
	
	public function getFavoriteGamesiteForLoggedInUser($user) {
		
		$favoriteSite = '';
		$databaseInfo = new DatabaseInfoModel();
	
		$con = new mysqli(
			$databaseInfo -> getHost(), 
			$databaseInfo -> getUser(), 
			$databaseInfo -> getPassword(), 
			$databaseInfo -> getDatabaseName(), 
			$databaseInfo -> getPort(), 
			$databaseInfo -> getSocket()
		) 
		or die ('Could not connect to the database server' . mysqli_connect_error());
		
		if ($stmt = $con -> prepare(
				$databaseInfo -> getFavoriteGamesiteStoredProcedure() . 
				'("'. $user .'")')) {
			
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