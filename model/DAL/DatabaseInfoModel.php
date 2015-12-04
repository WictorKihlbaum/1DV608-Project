<?php

class DatabaseInfoModel {
	
	// Public Database Connection Info.
	private $host = 'eu-cdbr-azure-north-d.cloudapp.net';
	private $port = 3306;
	private $socket = '';
	private $user = 'bd59d7069aef53';
	private $password = '6d5d241f';
	private $dbname = 'acsm_9268280c21a7845';
	
	// Stored Procedures.
	private $userCredentials = 'CALL getUserCredentials';
	private $rssFeeds = 'CALL getRSSFeeds';
	private $newUser = 'CALL addNewUser';
	private $favoriteGamesite = 'CALL getFavoriteGamesiteForUser'; 
	private $favoriteGamesiteUpdate = 'CALL updateFavoriteGamesiteForUser';
	
	
	public function getHost() {
		return $this -> host;	
	}
	
	public function getPort() {
		return $this -> port;	
	}
	
	public function getSocket() {
		return $this -> socket;
	}
	
	public function getUser() {
		return $this -> user;
	}
	
	public function getPassword() {
		return $this -> password;
	}
	
	public function getDatabaseName() {
		return $this -> dbname;
	}	
	
	public function getUserCredentialsStoredProcedure() {
		return $this -> userCredentials;
	}
	
	public function getRSSFeedsStoredProcedure() {
		return $this -> rssFeeds;
	}
	
	public function getAddNewUserStoredProcedure() {
		return $this -> newUser;
	}
	
	public function getFavoriteGamesiteStoredProcedure() {
		return $this -> favoriteGamesite;	
	}
	
	public function getUpdateFavoriteGamesiteStoredProcedure() {
		return $this -> favoriteGamesiteUpdate;
	}
	
}

