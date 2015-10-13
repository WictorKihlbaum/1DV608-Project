<?php

class SessionModel {
    
    private static $userSession = "SessionModel::UserSession";
    private static $newRegisteredUserSession = "SessionModel::NewRegisteredUserSession";
    private static $newUserNameSession = "SessionModel::NewUserNameSession";
    
    
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
    
}