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
						'. $this -> getNewsFeed() .'
					</main>
					<footer>
						<p>This is a footer</p>
					</footer>
				</body>
			</html>
		';	
	}
	
	private function getNewsFeed() {
	    
	    $newsfeed = "";
	    
	    $rss = new DOMDocument();
        $rss -> load('http://www.aftonbladet.se/rss.xml');
        
        
        $feed = array();
        
        foreach ($rss -> getElementsByTagName('item') as $node) {
	    
    	    $item = array (
    	        
    		    'title' => $node -> getElementsByTagName('title') -> item(0) -> nodeValue,
    		    'desc' => $node -> getElementsByTagName('description') -> item(0) -> nodeValue,
    		    'link' => $node -> getElementsByTagName('link') -> item(0) -> nodeValue,
    		    'date' => $node -> getElementsByTagName('pubDate') -> item(0) -> nodeValue,
    		    //'image' => $node -> getElementsByTagName('thumbnail') -> item(0) ? $node -> getElementsByTagName('thumbnail') -> item(0) -> getAttribute('url') : 'No image',
		    );
    		
    	    array_push($feed, $item);
        }
        
        
        $limit = 5;
        
        for ($x = 0; $x < $limit; $x++) {
            
        	$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
        	$link = $feed[$x]['link'];
        	$description = $feed[$x]['desc'];
        	$date = date('l F d, Y', strtotime($feed[$x]['date']));
        	//$image = $feed[$x]['image'];
        	
        	$newsfeed .= '<p><strong><a href="'. $link .' title="'. $title .'">'. $title .'</a></strong><br />' .
        	'<small><em>Posted on '. $date .'</em></small></p>'.
        	'<p>'. $description .'</p>';
        	
        	//'<img src="'.$image.'">' . 
        	// ^Put this before the 'p'-tag above.
        }
        
        return $newsfeed;
	}
	
}