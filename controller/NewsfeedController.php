<?php

class NewsfeedController {
    
    private $newsfeedView;
    private $newsfeedModel;
    
    //private $rssFeedArray;
    private $rssFeedString;
    
    
    public function __construct($newsfeedView, $newsfeedModel) {
        
        $this -> newsfeedView = $newsfeedView;
        $this -> newsfeedModel = $newsfeedModel;
    }
    
    public function handleRSSFeed() {
        
        $this -> newsfeedModel -> loadRSSFeed();
        $rssFeedArray = $this -> newsfeedModel -> getRSSFeedArray();
        $this -> createRSSFeedString($rssFeedArray);
        $this -> passNewsfeedToView();
    }
    
    private function createRSSFeedString($feed) {
		
		 date_default_timezone_set('Europe/Stockholm');
        
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
        	'<small><em>Posted on '. $date .'</em></small></p>'.
        	'<p>'. $description .'</p>';
        	
        	//'<img src="'.$image.'">' . 
        	// ^Put this before the 'p'-tag above.
        }
        
        $this -> rssFeedString = $newsfeed;
    }
    
    private function passNewsfeedToView() {
        
        $this -> newsfeedView -> setNewsfeed($this -> rssFeedString);
    }
}