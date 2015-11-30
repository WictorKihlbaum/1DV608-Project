<?php

class ServiceModel {

	private $userDAL;
	private $rssDAL;
	
	
	public function __constructor($userDAL, $rssDAL) {
		
		$this -> userDAL = new UserDAL();
		$this -> rssDAL = new RssDAL();
	}
	
	public function getRegisteredUsers() {
		
		$this -> makeSureUserDALIsNotNull();
		return $this -> userDAL -> getRegisteredUsers();
	}
	
	public function getRssCache() {
		
		if ($this -> rssDAL == null) {
			$this -> rssDAL = new RssDAL();
		}
		
		return $this -> rssDAL -> getRss();
	}
	
	public function addUser($newUser) {
		
		$this -> userDAL -> connectToServerAndAddUser($newUser);
	}
	
	public function addFavoriteGamesiteToUser($user, $favorite) {
	
		$this -> makeSureUserDALIsNotNull();
		$this -> userDAL -> connectToServerAndAddFavoriteGamesite($user, $favorite);	
	}
	
	public function getFavoriteGamesiteForLoggedInUser($user) {
		
		$this -> makeSureUserDALIsNotNull();
		return $this -> userDAL -> getFavoriteGamesiteForLoggedInUser($user);
	}
	
	private function makeSureUserDALIsNotNull() {
	
		if ($this -> userDAL == null) {
			$this -> userDAL = new UserDAL();
		}	
	}
	
}