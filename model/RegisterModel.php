<?php

class RegisterModel {
    
    private $sessionModel;
	private $userDAL;
	private $registeredUsersCache;
    
    
    public function __construct($sessionModel, $userDAL) {
        
        $this -> sessionModel = $sessionModel;
		$this -> userDAL = $userDAL;
    }
    
    public function validateUserInput($newUser) {
		
		$this -> registeredUsersCache = $this -> userDAL -> getRegisteredUsers();
		
		$userFound = false;
		
		foreach ($this -> registeredUsersCache as $user) {
		
			if ($user -> getUserName() === $newUser -> getUserName() &&
				$user -> getPassword() === $newUser -> getPassword()) {
				
				$userFound = true;
			} 
		}
		
		if (!$userFound) {
			
			$this -> sessionModel -> setNewRegisteredUserSession();
			$this -> userDAL -> connectToServerAndAddUser($newUser);
			// Session for the new users username in particular.
            $this -> sessionModel -> setNewUserNameSession($newUser -> getUserName()); 
			
		} else {
			
			throw new \UserAlreadyExistsException("User exists, pick another username");
		}
    }
     
    public function loggedInUser() {
        // Return session for user.
        return $this -> sessionModel -> getUserSession();
    }
}