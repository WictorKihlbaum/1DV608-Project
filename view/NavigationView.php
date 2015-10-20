<?php

class NavigationView {
	
	//private static $registerUserLink = "NavigationView::RegisterUserLink";
    //private static $registerURL = "register";
	private static $loginURL = "login";


	public function navigateToRegisterURL() {
	    
		header('Location:/?'. self::$loginURL);
		exit();
	}	
}