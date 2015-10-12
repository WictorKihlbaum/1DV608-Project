<?php

class LayoutView {
	
	private $homeView;
	private $registrationView;
	private $newsfeedView;
	private $aboutView;
	
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
								<li><a href="'.self::$homeURL.'">Home</a></li>
								<li><a href="'.self::$registrationURL.'">Registration</a></li>
								<li><a href="'.self::$newsfeedURL.'">Newsfeed</a></li>
								<li><a href="'.self::$aboutURL.'">About</a></li>
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