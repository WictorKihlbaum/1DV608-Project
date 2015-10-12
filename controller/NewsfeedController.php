<?php

class NewsfeedController {
    
    private $newsfeedView;
    private $newsfeedModel;
    
    //private $rssFeedArray;
    private $rssFeedString;
    
    
    public function __construct($newsfeedView, $newsfeedModel) {
		
        //date_default_timezone_set('Europe/Stockholm');
        $this -> newsfeedView = $newsfeedView;
        $this -> newsfeedModel = $newsfeedModel;
    }
    
    public function handleRSSFeed() {
        
        $this -> newsfeedModel -> loadRSSFeed();
        $rssFeedArray = $this -> newsfeedModel -> getRSSFeedArray();
		$this -> newsfeedView -> renderRSSFeed($rssFeedArray);
    }
    
}