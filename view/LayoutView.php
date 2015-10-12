<?php

class LayoutView {
	
	private $homeView;
	private $registrationView;
	private $newsfeedView;
	private $aboutView;
	
	private static $homeLink = "LayoutView::HomeLink";
	private static $registrationLink = "LayoutView::RegistrationLink";
	private static $newsfeedLink = "LayoutView::NewsfeedLink";
	private static $aboutLink = "LayoutView::AboutLink";
	
	private static $homeURL = "?";
	private static $registrationURL = "registration";
	private static $newsfeedURL = "newsfeed";
	private static $aboutURL = "about";
	
	
	
	public function __construct($homeView, $registrationView, $newsfeedView, $aboutView) {
	
		$this -> homeView = $homeView;
		$this -> registrationView = $registrationView;
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
					<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css">
					<link rel="stylesheet" type="text/css" href="css/style.css">
					<link rel="stylesheet" type="text/css" href="css/navigation.css">
				</head>
				<body>
					<header>
						<nav>
							<ul>
								<li><a href="'. self::$homeURL .' name='. self::$homeLink .'">Home</a></li>
								<li><a href="?'. self::$registrationURL .' name='. self::$registrationLink .'">Registration</a></li>
								<li><a href="?'. self::$newsfeedURL .' name='. self::$newsfeedLink .'">Newsfeed</a></li>
								<li><a href="?'. self::$aboutURL .' name='. self::$aboutLink .'">About</a></li>
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
		
		/*if (isset($_POST[self::$newsfeedLink])) {
		
			return $this -> newsfeed -> response();
			
		} else {
		
			return "<h1>HomeView</h1>";	
		}*/
	
		switch ($_SERVER['QUERY_STRING']) {
		
			case self::$homeURL: 
				return $this -> homeView -> response();
				break;
				
			case self::$registrationURL: 
				return $this -> registrationView -> response();
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