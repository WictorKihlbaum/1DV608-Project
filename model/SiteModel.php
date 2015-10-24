<?php

class SiteModel {

	private $siteName;
	private $news;
	
	
	public function __construct($siteName, $news) {
		
		$this -> siteName = $siteName;
		$this -> news = $news;
	}
	
	public function getSiteName() {
	
		return $this -> siteName;	
	}
	
	public function getNews() {
	
		return $this -> news;	
	}
	
}