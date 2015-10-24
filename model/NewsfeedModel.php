<?php

class NewsfeedModel {
	
	private $userDAL;
	private $retrievedRssArray = array();
	private $siteArray = array();
    
	
	public function __construct($userDAL) {
	
		$this -> userDAL = $userDAL;
	}
	
	public function retrieveRssFromDAL() {
	
		$this -> retrievedRssArray = $this -> userDAL -> getRss();
	}
    
    public function loadRSSFeed() {
		
		foreach ($this -> retrievedRssArray as $retrievedRss) {
			
			$itemArray = array();
			
			$rss = new DOMDocument();
			$rss -> load($retrievedRss -> getRssLink());
			
			foreach ($rss -> getElementsByTagName('item') as $node) {
			
				$item = new ItemModel(
				
					// Common tags.
					$node -> getElementsByTagName('title') -> item(0) -> nodeValue,
					$node -> getElementsByTagName('description') -> item(0) -> nodeValue,
					$node -> getElementsByTagName('link') -> item(0) -> nodeValue,
					$node -> getElementsByTagName('pubDate') -> item(0) -> nodeValue
					
					// Uncommon tags. Return empty string if they don't exist.
					//$node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue ? $node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue : ''
				);
			
						/*
						$item = array (
							
							// Common xml-tags in rssfeeds.
							'title' => $node -> getElementsByTagName('title') -> item(0) -> nodeValue,
							'desc' => $node -> getElementsByTagName('description') -> item(0) -> nodeValue,
							'link' => $node -> getElementsByTagName('link') -> item(0) -> nodeValue,
							'date' => $node -> getElementsByTagName('pubDate') -> item(0) -> nodeValue,
							
							// Uncommon xml-tags in rssfeeds. Check if they exist. If not - return empty string.
							'image' => $node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue ? $node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue : '',
						);
						*/
				
				$itemArray[] = $item;
			}
			
			$site = new SiteModel($retrievedRss -> getSiteName(), $itemArray);
			$this -> siteArray[] = $site;
		}  
    }
    
    public function getSiteArray() {
        
        return $this -> siteArray;
    }
    
}