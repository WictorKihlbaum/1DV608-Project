<?php

class NewsfeedController {
    
    private $newsfeedView;
    private $newsfeedModel;
	private $sessionModel;
    private $rssFeedString;
    
    
    public function __construct($newsfeedView, $newsfeedModel, $sessionModel) {
		
        $this -> newsfeedView = $newsfeedView;
        $this -> newsfeedModel = $newsfeedModel;
		$this -> sessionModel = $sessionModel;
    }
    
    public function handleRSSFeed() {
        
        $this -> newsfeedModel -> loadRSSFeed();
        $rssFeedArray = $this -> newsfeedModel -> getRSSFeedArray();
		$this -> newsfeedView -> renderRSSFeed($rssFeedArray);
    }
	
	public function verifyNewsfeedSettings() {
	
		if ($this -> newsfeedView -> didUserPressUpdate()) {
			
			$limitOfNews = $this -> newsfeedView -> getLimitOfNews();
			$this -> sessionModel -> setNumberOfNewsSession($limitOfNews);
			
			$limitOfSites = $this -> newsfeedView -> getLimitOfSites();
			$this -> sessionModel -> setNumberOfSitesSession($limitOfSites);
		}
	}
    
}