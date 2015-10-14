<?php

class LoginModel {

    private $sessionModel;
	private $userDAL;
	private $registeredUsersCache;
    
    
    public function __construct($sessionModel, $userDAL) {
        
        $this -> sessionModel = $sessionModel;
		$this -> userDAL = $userDAL;
    }

    public function validateUserInput($input) {
		
		$this -> userDAL -> connectToServerAndFetchUsers();
		$this -> registeredUsersCache = $this -> userDAL -> getRegisteredUsers();
		
		$userFound = false;
		
		foreach ($this -> registeredUsersCache as $user) {
		
			if ($user -> getUserName() === $input -> getUserName() &&
				$user -> getPassword() === $input -> getPassword()) {
				
				$userFound = true;
			} 
		}
		
		if ($userFound) {
			$this -> sessionModel -> setUserSession();
		} else {
			throw new \WrongInputException("Wrong name or password");
		}
    }
    
    public function logoutUser() {
        // Remove user-session when user is being logged out.
        $this -> sessionModel -> unsetUserSession();
    }
    
    public function loggedInUser() {
        // Return session for user.
        return $this -> sessionModel -> getUserSession();
    }
    
}