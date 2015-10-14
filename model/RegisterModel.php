<?php

class RegisterModel {
    
    private $sessionModel;
    private $registeredUsersFile;
	private $userDAL;
	private $registeredUsersCache;
    
    
    public function __construct($sessionModel, $registeredUsersFile, $userDAL) {
        
        $this -> sessionModel = $sessionModel;
        $this -> registeredUsersFile = $registeredUsersFile;
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
			$this -> userDAL -> connectToServerAndAddUser($newUser);
		} else {
			throw new \UserAlreadyExistsException("User exists, pick another username");
		}
		
		
        /*
        $inputToSearchFor = "Username: " . $newUser -> getUserName() . " Password: " . $newUser -> getPassword();
        $textFileToSearchIn = file_get_contents($this -> registeredUsersFile);
        $textFileToSearchIn = explode("\n", $textFileToSearchIn);
        
        if (in_array($inputToSearchFor, $textFileToSearchIn)) {
        
            throw new \UserAlreadyExistsException("User exists, pick another username");
            
        } else {
            
            $this -> saveNewUserToTextFile($newUser);
            
            $this -> sessionModel -> setNewRegisteredUserSession();
            // Session for the new users username in particular.
            $this -> sessionModel -> setNewUserNameSession($newUser -> getUserName()); 
        }
		*/
    }
    
    private function saveNewUserToTextFile($newUser) {
                
        // Open the file to get existing content.
        $fileContent = file_get_contents($this -> registeredUsersFile);
        // Save new user to the textfile.
        $fileContent .= "\nUsername: " . $newUser -> getUserName() . " Password: " . $newUser -> getPassword();
        // Write the content back to the textfile.
        file_put_contents($this -> registeredUsersFile, $fileContent);
    }
    
    public function loggedInUser() {
        // Return session for user.
        return $this -> sessionModel -> getUserSession();
    }
}