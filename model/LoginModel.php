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
		$salt = $this -> getSalt();
		
		$userFound = false;
		
		foreach ($this -> registeredUsersCache as $user) {
		
			/*if ($user -> getUserName() === $input -> getUserName() &&
				$user -> getPassword() === $input -> getPassword()) {
				
				$userFound = true;
			}*/
			
			if ($user -> getUserName() === $input -> getUserName() &&
				$this -> getSalt() == true) {
				
				$userFound = true;
			} 
		}
		
		if ($userFound) {
			
			$this -> sessionModel -> setUserSession();
			
		} else {
			
			throw new \WrongInputException();
		}
    }
	
	private function getSalt($password, $input) {
		
		$cost = 10;
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt = sprintf('$2a$%02d$', $cost) . $salt;
		$hash = crypt($input, $salt);
		
		if ($password === $hash) {
			
			return true;
		}
		
		return false;
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