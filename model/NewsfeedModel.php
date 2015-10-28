<?php

class NewsfeedModel {
	
	private $serviceModel;
	private $retrievedRssArray = array();
	private $siteArray = array();
    
	
	public function __construct($serviceModel) {
	
		$this -> serviceModel = $serviceModel;
	}
    
    public function loadRSSFeed() {
		
		$this -> retrievedRssArray = $this -> serviceModel -> getRssCache();
		
		foreach ($this -> retrievedRssArray as $retrievedRss) {
			
			$itemArray = array();
			
			// Create DOM-doc for every RSS-feed and load it.
			$rss = new DOMDocument();
			$rss -> load($retrievedRss -> getRssLink());
			
			foreach ($rss -> getElementsByTagName('item') as $node) {
				
				$item = new ItemModel(
				
					// Standard tags.
					$node -> getElementsByTagName('title') -> item(0) -> nodeValue,
					$node -> getElementsByTagName('description') -> item(0) -> nodeValue,
					$node -> getElementsByTagName('link') -> item(0) -> nodeValue,
					$node -> getElementsByTagName('pubDate') -> item(0) -> nodeValue,
	
					// Non standard tags. Return empty string if they don't exist.
					$node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue ? $node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue : ''
				);
				
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