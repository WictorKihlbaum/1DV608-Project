<?php

class LoginModel {

    private $sessionModel;
	private $serviceModel;
	private $registeredUsersCache;
    
    
    public function __construct($sessionModel, $serviceModel) {
        
        $this -> sessionModel = $sessionModel;
		$this -> serviceModel = $serviceModel;
    }

    public function validateUserInput($input) {
		
		$this -> registeredUsersCache = $this -> serviceModel -> getRegisteredUsers();
		
		$userFound = false;
		
		foreach ($this -> registeredUsersCache as $user) {
			
			if ($user -> getUserName() === $input -> getUserName() &&
				$this -> validatePassword($user -> getPassword(), $input -> getPassword())) {
				
				$userFound = true;
			} 
		}
		
		if ($userFound) {
			
			$this -> sessionModel -> setUserSession();
			$this -> sessionModel -> setLoggedInUserNameSession($user -> getUserName());
			
		} else {
			
			throw new \WrongInputException();
		}
    }
	
	private function validatePassword($storedPassword, $inputPassword) {

		if (password_verify($inputPassword, $storedPassword)) {
			
			return true;
		}
			
		return false;
	}
    
    public function logoutUser() {
        // Remove user-session when user is being logged out.
        $this -> sessionModel -> unsetUserSession();
		$this -> sessionModel -> unsetLoggedInUserNameSession();
    }
    
    public function loggedInUser() {
        // Return session for user.
        return $this -> sessionModel -> getUserSession();
    }
	
	public function setFavoriteGamesite($user, $favorite) {
	
		$this -> serviceModel -> addFavoriteGamesiteToUser($user, $favorite);
	}
    
}