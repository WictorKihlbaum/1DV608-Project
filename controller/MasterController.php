<?php

class MasterController {

	private $loginController;
	private $registerController;
	
	
	public function __construct($loginController, $registerController) {
	
		$this -> loginController = $loginController;	
		$this -> registerController = $registerController;
	}
	
	public function handleUserRequest() {
		
		$this -> loginController -> verifyUserState();
		$this -> registerController -> verifyUserState();
	}
}