<?php

class RegisterController {
    
    private $registerView;
    private $registerModel;
    
    
    public function __construct($registerView, $registerModel) {
        
        $this -> registerView = $registerView;
        $this -> registerModel = $registerModel;
    }
	
	public function reforwardDidUserPressRegister() {
		
		return $this -> registerView -> didUserPressRegister();	
	}
    
    public function verifyUserState() {
        
        try {
            
            if (!$this -> registerModel -> loggedInUser() &&
                 $this -> registerView -> didUserPressRegister()) {
            
                $this -> registerUser();
            
            } else if ($this -> registerModel -> loggedInUser() &&
                       $this -> registerView -> didUserPressRegister()) {
            
                throw new \RegisterWhileLoggedInException();
            }
            
        } catch (RegisterWhileLoggedInException $e) {
            // User should not be able to register while logged in.
            $this -> registerView -> setRegisterWhileLoggedInFeedbackMessage();
        }
    }
    
    private function registerUser() {
        
         $newUser = $this -> registerView -> getNewUser();
         
         try {
            
            if ($newUser != null) {
                
                $this -> registerModel -> validateUserInput($newUser);
            }
  
        } catch (UserAlreadyExistsException $e) {
            
            $this -> registerView -> setUserAlreadyExistsFeedbackMessage();
        }
    }
    
}