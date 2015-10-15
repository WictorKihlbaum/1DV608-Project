<?php

class MasterController {

	private $loginController;
	private $registerController;
	private $newsfeedController;
	
	
	public function __construct($loginController, $registerController, $newsfeedController) {
	
		$this -> loginController = $loginController;	
		$this -> registerController = $registerController;
		$this -> newsfeedController = $newsfeedController;
	}
	
	public function handleUserRequest() {
		
		$this -> loginController -> verifyUserState();
		$this -> registerController -> verifyUserState();
		$this -> newsfeedController -> handleRSSFeed();
	}
}