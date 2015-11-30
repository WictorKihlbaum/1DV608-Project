<?php

class MasterController {

	private $homeController;
	private $loginController;
	private $registerController;
	private $newsfeedController;
	private $contactController;
	
	
	public function __construct($homeController, $loginController, $registerController, $newsfeedController, $contactController) {
		
		$this -> homeController = $homeController;
		$this -> loginController = $loginController;	
		$this -> registerController = $registerController;
		$this -> newsfeedController = $newsfeedController;
		$this -> contactController = $contactController;
	}
	
	public function handleUserRequest() {
		
		$this -> homeController -> handleRSSFeed();
		
		// USER PRESS LOGIN.
		if ($this -> loginController -> reforwardDidUserPressLogin()) {
			
			$this -> loginController -> verifyUserState();
		}
		
		$this -> loginController -> setUserFavoriteGamesite();
		
		// USER PRESS LOGOUT.
		if ($this -> loginController -> reforwardDidUserPressLogout()) {
			
			$this -> loginController -> verifyUserState();
		}
		
		// USER PRESS REGISTER.
		if ($this -> registerController -> reforwardDidUserPressRegister()) {
			
			$this -> registerController -> verifyUserState();
		}
		
		// USER PRESS SEND (CONTACTFORM-MESSAGE).
		if ($this -> contactController -> reforwardDidUserPressSend()) {
			
			$this -> contactController -> handleContactForm();
		}
		
		// USER WANTS TO SEE NEWSFEED. 
		if ($_SERVER['QUERY_STRING'] == 'newsfeed') {
			
			$this -> newsfeedController -> handleRSSFeed();
			$this -> newsfeedController -> verifyNewsfeedSettings();
		}
	}
	
}