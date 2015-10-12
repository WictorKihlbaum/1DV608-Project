<?php

class NewsfeedView {
    
    private $newsfeed = "";
	
	
	public function response() {
	
		return "<h1>NewsfeedView</h1>";	
	}
    
    public function getNewsFeed() {
			
        return $this -> newsfeed;
    }
    
    private function setNewsfeed($newsfeed) {
        
        $this -> newsfeed = $newsfeed;
    }
	
	public function renderRSSFeed($feed) {
	
		//date_default_timezone_set('Europe/Stockholm');
        
        $newsfeed = "";
        $limit = 5;
        
        for ($x = 0; $x < $limit; $x++) {
            
        	//$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']); Need?
			$title = $feed[$x]['title'];
        	$link = $feed[$x]['link'];
        	$description = $feed[$x]['desc'];
        	$date = date('l F d, Y', strtotime($feed[$x]['date']));
        	//$image = $feed[$x]['image'];
        	
        	$newsfeed .= '<p><strong><a href="'. $link .' title="'. $title .'">'. $title .'</a></strong><br />' .
        	'<small>Posted on '. $date .'</small></p>'.
        	'<p>'. $description .'</p>';
        	
        	//'<img src="'.$image.'">' . 
        	// ^Put this before the 'p'-tag above.
        }
		
        $this -> setNewsfeed($newsfeed);
	}
    
}