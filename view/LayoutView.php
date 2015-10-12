<?php

class LayoutView {
	
	public function render($newsfeedView) {
	
		echo '
		    <!doctype html>
			<html>
				<head>
					<meta charset="utf-8">
					<title>ProjectSite</title>
					<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css">
					<link rel="stylesheet" type="text/css" href="css/style.css">
				</head>
				<body>
					<header>
						<h1>Welcome</h1>
					</header>
					<main>
						<h2>Here you will see newsfeed</h2>
						<div class="rssFeed">
							'. $newsfeedView -> getNewsfeed() .'
						</div>
					</main>
					<footer>
						<p><h3>This is a footer</h3></p>
					</footer>
				</body>
			</html>
		';	
	}
	
	
	
}