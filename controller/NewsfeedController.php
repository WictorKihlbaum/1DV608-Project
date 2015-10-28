<?php

class NewsfeedController {
    
    private $newsfeedView;
    private $newsfeedModel;
	private $sessionModel;
    
    
    public function __construct($newsfeedView, $newsfeedModel, $sessionModel) {
		
        $this -> newsfeedView = $newsfeedView;
        $this -> newsfeedModel = $newsfeedModel;
		$this -> sessionModel = $sessionModel;
    }
    
    public function handleRSSFeed() {
        
        $this -> newsfeedModel -> loadRSSFeed();
        $siteArray = $this -> newsfeedModel -> getSiteArray();
		$this -> newsfeedView -> setSiteArray($siteArray);
    }
	
	public function verifyNewsfeedSettings() {
	
		// Get and set limit of news.
		$limitOfNews = $this -> newsfeedView -> getLimitOfNews();
		$this -> sessionModel -> setNumberOfNewsSession($limitOfNews);
		// Get and set limit of sites.
		$limitOfSites = $this -> newsfeedView -> getLimitOfSites();
		$this -> sessionModel -> setNumberOfSitesSession($limitOfSites);	
	}
    
}