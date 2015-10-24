<?php

class RssModel {

	private $siteName;
	private $rssLink;
	
	
	public function __construct($siteName, $rssLink) {
		
		$this -> siteName = $siteName;
		$this -> rssLink = $rssLink;
	}
	
	public function getSiteName() {
	
		return $this -> siteName;	
	}
	
	public function getRssLink() {
	
		return $this -> rssLink;	
	}
}