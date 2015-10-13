<?php

class MasterController {

	private $loginController;
	
	
	public function __construct($loginController) {
	
		$this -> loginController = $loginController;	
	}
	
	public function handleUserRequest() {
		
		$this -> loginController -> verifyUserState();
	}
}