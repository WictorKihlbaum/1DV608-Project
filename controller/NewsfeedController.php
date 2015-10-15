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
		$this -> newsfeedView -> renderRSSFeed($rssFeedArray);
    }
    
}