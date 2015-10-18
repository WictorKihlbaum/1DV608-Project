<?php

class LayoutView {
	
	private $homeView;
	private $loginView;
	private $registerView;
	private $newsfeedView;
	private $aboutView;
	
	private static $homeLink = "LayoutView::HomeLink";
	private static $loginLink = "LayoutView::LoginLink";
	private static $newsfeedLink = "LayoutView::NewsfeedLink";
	private static $aboutLink = "LayoutView::AboutLink";
	
	private static $homeURL = "home";
	private static $loginURL = "login";
	private static $registerURL = "register";
	private static $newsfeedURL = "newsfeed";
	private static $aboutURL = "about";
	
	private static $mainFont = "<link href='https://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>";
	private static $navigationFont = "<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>";
	
	
	public function __construct($homeView, $loginView, $registerView, $newsfeedView, $aboutView) {
	
		$this -> homeView = $homeView;
		$this -> loginView = $loginView;
		$this -> registerView = $registerView;
		$this -> newsfeedView = $newsfeedView;
		$this -> aboutView = $aboutView;
	}
	
	public function renderLayout() {
	
		echo '
		    <!doctype html>
			<html>
				<head>
					<meta charset="utf-8">
					<title>ProjectSite</title>
					'. self::$mainFont .'
					'. self::$navigationFont .'
					<link rel="stylesheet" type="text/css" href="css/style.css">
					<link rel="stylesheet" type="text/css" href="css/navigation.css">
					<link rel="stylesheet" type="text/css" href="css/login.css">
					<link rel="stylesheet" type="text/css" href="css/register.css">
					<link rel="stylesheet" type="text/css" href="css/newsfeed.css">
				</head>
				<body>
					<header>
						<nav>
							<ul>
								<li><a href="?'. self::$homeURL .'" name="'. self::$homeLink .'">Home</a></li>
								<li><a href="?'. self::$loginURL .'" name="'. self::$loginLink .'">Login</a></li>
								<li><a href="?'. self::$newsfeedURL .'" name="'. self::$newsfeedLink .'">Newsfeed</a></li>
								<li><a href="?'. self::$aboutURL .'" name="'. self::$aboutLink .'">About</a></li>
							</ul>
            			</nav>
					</header>
					<main>
						'. $this -> renderContent() .'
					</main>
					<footer>
						<p>© 2015 FeedRedirect</p>
					</footer>
				</body>
			</html>
		';	
	}
	
	private function renderContent() {
		
		switch ($_SERVER['QUERY_STRING']) {
		
			case self::$homeURL: 
				return $this -> homeView -> response();
				break;
				
			case self::$loginURL: 
				return $this -> loginView -> response();
				break;
				
			case self::$registerURL: 
				return $this -> registerView -> response();
				break;
				
			case self::$newsfeedURL: 
				return $this -> newsfeedView -> response();
				break;
				
			case self::$aboutURL: 
				return $this -> aboutView -> response();
				break;
			
			default: 
				return $this -> homeView -> response();
				break;	
		}
	}
	
}