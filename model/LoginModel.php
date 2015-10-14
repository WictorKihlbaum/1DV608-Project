<?php

class LoginModel {

    private $sessionModel;
    private $registeredUsersFile;
	private $userDAL;
	private $registeredUsersCache;
    
    
    public function __construct($sessionModel, $registeredUsersFile, $userDAL) {
        
        $this -> sessionModel = $sessionModel;
        $this -> registeredUsersFile = $registeredUsersFile;
		$this -> userDAL = $userDAL;
    }

    public function validateUserInput($input) {
		
		$this -> userDAL -> connectToServerAndFetchUsers();
		$this -> registeredUsersCache = $this -> userDAL -> getRegisteredUsers();
		
		foreach ($this -> registeredUsersCache as $user) {
		
			if ($user -> getUserName() == $input -> getUserName() &&
				$user -> getPassword() == $input -> getPassword()) {
				
				$this -> sessionModel -> setUserSession();
				
			} else {
			
				throw new \WrongInputException();	
			}
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