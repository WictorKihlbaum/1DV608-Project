<?php

class RegisterModel {
    
    private $sessionModel;
    private $registeredUsersFile;
    
    
    public function __construct($sessionModel, $registeredUsersFile) {
        
        $this -> sessionModel = $sessionModel;
        $this -> registeredUsersFile = $registeredUsersFile;
    }
    
    public function validateUserInput($newUser) {
        
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