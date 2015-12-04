<?php

class SessionModel {
    
    private static $userSession = "SessionModel::UserSession";
    private static $newRegisteredUserSession = "SessionModel::NewRegisteredUserSession";
    private static $newUserNameSession = "SessionModel::NewUserNameSession";
	private static $numberOfNewsSession = "SessionModel::NumbersOfNewsSession";
	private static $numberOfSitesSession = "SessionModel::NumberOfSitesSession";
	private static $userNameSession = "SessionModel::UserNameSession";
    
    
    public function __construct() {
        // Start the session as first thing to do when 'SessionModel' is being created. 
        session_start();
    }
    
    
    // SESSION FOR USER.
    
    public function setUserSession() {
        // This will keep track on whether the user is logged in or not.
        $_SESSION[self::$userSession] = true;
    }
    
    public function unsetUserSession() {
        // Removes the created session.
        unset($_SESSION[self::$userSession]);
    }
    
    public function getUserSession() {
        
        if (isset($_SESSION[self::$userSession])) {
        
            return $_SESSION[self::$userSession];
        }
        
        return false;
    }
	
	// SESSION FOR LOGGED IN USER'S USERNAME.
	
	public function setLoggedInUserNameSession($userName) {
		
		$_SESSION[self::$userNameSession] = $userName;
	}
	
	public function isLoggedInUserNameSessionSet() {
		
		return isset($_SESSION[self::$userNameSession]);
    }
	
	public function getLoggedInUserNameSession() {
	
		if (isset($_SESSION[self::$userNameSession])) {
        
            return $_SESSION[self::$userNameSession];
        }
        
        return false;	
	}
	
	public function unsetLoggedInUserNameSession() {
	
		unset($_SESSION[self::$userNameSession]);
	}
    
    // SESSION FOR NEW REGISTERED USER. 
    
    public function setNewRegisteredUserSession() {
        
        $_SESSION[self::$newRegisteredUserSession] = true;
    }
    
    public function unsetNewRegisteredUserSession() {
        
        unset($_SESSION[self::$newRegisteredUserSession]);
    }
    
    public function isNewRegisteredUserSessionSet() {
        
        return isset($_SESSION[self::$newRegisteredUserSession]);
    }
    
    
    // SESSION FOR USERNAME IN PARTICULAR.
    
    public function setNewUserNameSession($newUserName) {
        
        $_SESSION[self::$newUserNameSession] = $newUserName;
    }
    
    public function unsetNewUserNameSession() {
        
        unset($_SESSION[self::$newUserNameSession]);
    }
    
    public function isNewUserNameSessionSet() {
        
        return isset($_SESSION[self::$newUserNameSession]);
    }
    
    public function getNewUserNameSession() {
        
        return $_SESSION[self::$newUserNameSession];
    }
	
	
	// NEWSFEED-RELATED.
	
	// NUMBER OF NEWS.
	public function setNumberOfNewsSession($number) {
	
		$_SESSION[self::$numberOfNewsSession] = $number;	
	}
	
	public function isNumberOfNewsSessionSet() {
        
        return isset($_SESSION[self::$numberOfNewsSession]);
    }
    
    public function getNumberOfNewsSession() {
        
        return $_SESSION[self::$numberOfNewsSession];
    }
	
	// NUMBER OF SITES.
	public function setNumberOfSitesSession($number) {
	
		$_SESSION[self::$numberOfSitesSession] = $number;	
	}
	
	public function isNumberOfSitesSessionSet() {
        
        return isset($_SESSION[self::$numberOfSitesSession]);
    }
    
    public function getNumberOfSitesSession() {
        
        return $_SESSION[self::$numberOfSitesSession];
    }
    
}