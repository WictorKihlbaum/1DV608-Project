<?php

class UserModel {

    private $username;
    private $password;
	private $favoriteGamesite;


    public function __construct($username, $password, $favoriteGamesite) {
        
        $this -> username = $username;
        $this -> password = $password;
		$this -> favoriteGamesite = $favoriteGamesite;
    }

    public function getUserName() {

        return $this -> username;
    }

    public function getPassword() {

        return $this -> password;
    }
	
	public function getFavoriteGamesite() {
	
		return $this -> favoriteGamesite;	
	}
	
	public function setFavoriteGamesite($favoriteGamesite) {
	
		$this -> favoriteGamesite = $favoriteGamesite;
	}
	
}