<?php

class LayoutView {
	
	public function render($newsfeedView) {
	
		echo '
		    <!doctype html>
			<html>
				<head>
					<meta charset="utf-8">
					<title>ProjectSite</title>
				</head>
				<body>
					<header>
						<h1>Welcome</h1>
					</header>
					<main>
						<h2>Here you will see newsfeed</h2>
						'. $newsfeedView -> getNewsfeed() .'
					</main>
					<footer>
						<p>This is a footer</p>
					</footer>
				</body>
			</html>
		';	
	}
	
}