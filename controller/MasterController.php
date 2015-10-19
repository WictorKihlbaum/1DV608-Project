<?php

class MasterController {

	private $loginController;
	private $registerController;
	private $newsfeedController;
	private $contactController;
	
	
	public function __construct($loginController, $registerController, $newsfeedController, $contactController) {
	
		$this -> loginController = $loginController;	
		$this -> registerController = $registerController;
		$this -> newsfeedController = $newsfeedController;
		$this -> contactController = $contactController;
	}
	
	public function handleUserRequest() {
		
		$this -> loginController -> verifyUserState();
		$this -> registerController -> verifyUserState();
		
		$this -> newsfeedController -> handleRSSFeed();
		$this -> newsfeedController -> verifyNewsfeedSettings();
		
		$this -> contactController -> handleContactForm();
	}
}