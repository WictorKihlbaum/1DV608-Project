<?php

class LayoutView {
	
	private $homeView;
	private $loginView;
	private $registerView;
	private $newsfeedView;
	private $contactView;
	
	private static $homeLink = 'LayoutView::HomeLink';
	private static $loginLink = 'LayoutView::LoginLink';
	private static $newsfeedLink = 'LayoutView::NewsfeedLink';
	private static $contactLink = 'LayoutView::ContactLink';
	
	private static $homeURL = 'home';
	private static $loginURL = 'login';
	private static $registerURL = 'register';
	private static $newsfeedURL = 'newsfeed';
	private static $contactURL = 'contact';
	
	// FONTS FROM GOOGLE-FONTS.
	private static $mainFont = "<link href='https://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>";
	private static $navigationFont = "<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>";
	
	
	public function __construct($homeView, $loginView, $registerView, $newsfeedView, $contactView) {
	
		$this -> homeView = $homeView;
		$this -> loginView = $loginView;
		$this -> registerView = $registerView;
		$this -> newsfeedView = $newsfeedView;
		$this -> contactView = $contactView;
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
					<link rel="stylesheet" type="text/css" href="css/main.css">
					<link rel="stylesheet" type="text/css" href="css/navigation.css">
					<link rel="stylesheet" type="text/css" href="css/login.css">
					<link rel="stylesheet" type="text/css" href="css/register.css">
					<link rel="stylesheet" type="text/css" href="css/newsfeed.css">
					<link rel="stylesheet" type="text/css" href="css/contact.css">
				</head>
				<body>
					<header>
						<nav>
							<ul>
								<li><a href="?'. self::$homeURL .'" name="'. self::$homeLink .'">Home</a></li>
								<li><a href="?'. self::$loginURL .'" name="'. self::$loginLink .'">Login</a></li>
								<li><a href="?'. self::$newsfeedURL .'" name="'. self::$newsfeedLink .'">Newsfeed</a></li>
								<li><a href="?'. self::$contactURL .'" name="'. self::$contactLink .'">Contact</a></li>
							</ul>
            			</nav>
					</header>
					<!-- Span is set to block in CSS to push content down from fixed menu.
						 A-tag is just an anchor. -->
					<a name="top"></a>
					<span id="blockElement"></span>
					<main>
						'. $this -> renderContent() .'
					</main>
					<footer>
						<p id="toTopAnchor"><a href="#top">Return to the top</a></p>
						<p>© 2015 Gamefeed</p>
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
				
			case self::$contactURL: 
				return $this -> contactView -> response();
				break;
			
			default: 
				return $this -> homeView -> response();
				break;	
		}
	}
	
}