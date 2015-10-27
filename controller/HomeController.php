<?php

class HomeController {

	private $homeView;
	private $homeModel;
	private $sessionModel;
	
	
	public function __construct($homeView, $homeModel, $sessionModel) {
		
		$this -> homeView = $homeView;
		$this -> homeModel = $homeModel;
		$this -> sessionModel = $sessionModel;
	}
	
	public function handleRSSFeed() {
		
		$this -> homeModel -> loadRSSFeed();
        $siteArray = $this -> homeModel -> getSiteArray();
		$this -> homeView -> setSiteArray($siteArray);
	}
	
}