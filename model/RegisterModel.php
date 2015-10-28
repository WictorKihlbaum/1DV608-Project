<?php

class RegisterModel {
    
    private $sessionModel;
	private $serviceModel;
	private $registeredUsersCache;
    
    
    public function __construct($sessionModel, $serviceModel) {
        
        $this -> sessionModel = $sessionModel;
		$this -> serviceModel = $serviceModel;
    }
    
    public function validateUserInput($newUser) {
		
		$this -> registeredUsersCache = $this -> serviceModel -> getRegisteredUsers();
		
		$userFound = false;
		
		foreach ($this -> registeredUsersCache as $user) {
		
			if ($user -> getUserName() === $newUser -> getUserName() &&
				$user -> getPassword() === $newUser -> getPassword()) {
				
				$userFound = true;
			} 
		}
		
		if (!$userFound) {
			
			$this -> sessionModel -> setNewRegisteredUserSession();
			// Session for the new users username in particular.
            $this -> sessionModel -> setNewUserNameSession($newUser -> getUserName());
			$this -> registeredUsersCache[] = $newUser;
			$this -> serviceModel -> addUser($newUser);
			 
		} else {
			
			throw new \UserAlreadyExistsException();
		}
    }
     
    public function loggedInUser() {
        // Return session for user.
        return $this -> sessionModel -> getUserSession();
    }
}