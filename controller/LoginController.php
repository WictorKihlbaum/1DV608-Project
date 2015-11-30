<?php

class LoginController {

    private $loginView;
    private $loginModel;
    private $sessionModel;


    public function __construct($loginView, $loginModel, $sessionModel) {

        $this -> loginView = $loginView;
        $this -> loginModel = $loginModel;
        $this -> sessionModel = $sessionModel;
    }
	
	public function reforwardDidUserPressLogin() {
		
		return $this -> loginView -> didUserPressLogin();	
	}
	
	public function reforwardDidUserPressLogout() {
	
		return $this -> loginView -> didUserPressLogout();	
	}
    
    public function verifyUserState() {
        
        // Verify if a user has recently been registered.
        if ($this -> sessionModel -> isNewRegisteredUserSessionSet()) {
            // Show feedbackmessage and remove the session directly after.
            $this -> loginView -> setRegisteredNewUserFeedbackMessage();
            $this -> sessionModel -> unsetNewRegisteredUserSession();
        }
        
        // If user not already logged in - login user.
        if (!$this -> loginModel -> loggedInUser() && 
             $this -> loginView -> didUserPressLogin()) {
              
              $this -> loginUser();
        // If user pressed logout while logged in - logout user.
        } else if ($this -> loginModel -> loggedInUser() && 
                   $this -> loginView -> didUserPressLogout()) {
              
              $this -> logOutUser();
        }
        // Return session for user.
        return $this -> loginModel -> loggedInUser();
    }
    
    public function loginUser() {
        
        // Get user object containing the posted form inputs (username/password).
        $user = $this -> loginView -> getUser();
        
        try { // Validate user input and set feedback message thereafter.
            
            if ($user != null) {
                
                $this -> loginModel -> validateUserInput($user);
                $this -> loginView -> setLoginFeedbackMessage();
                // Unsets the newly added username-session first after the login-button has been pressed.
                $this -> sessionModel -> unsetNewUserNameSession();
            }
  
        } catch (WrongInputException $e) {
            
            $this -> loginView -> setWrongInputFeedbackMessage();
        }
    }
	
	public function setUserFavoriteGamesite() {
	
		if ($this -> loginView -> didUserPressChoose()) {
			
			if ($this -> sessionModel -> isLoggedInUserNameSessionSet()) {
				$user = $this -> sessionModel -> getLoggedInUserNameSession();
			}
			
			$favorite = $this -> loginView -> getRequestFavoriteGamesite();
			
			$this -> loginModel -> setFavoriteGamesite($user, $favorite);
		}
	}
    
    public function logOutUser() {
        // Logout user and set/present feedback message.
        $this -> loginView -> setLogoutFeedbackMessage();
        $this -> loginModel -> logoutUser();
    }
    
}