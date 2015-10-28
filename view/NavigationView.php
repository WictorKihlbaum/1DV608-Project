<?php

class NavigationView {
	
	private static $loginURL = "login";


	public function navigateToRegisterURL() {
	    
		header('Location:/?'. self::$loginURL);
		exit();
	}	
}