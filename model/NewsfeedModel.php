<?php

class NewsfeedModel {
    
	// RSSFeeds.
	private static $gamereactorRSS = "https://www.gamereactor.se/rss/rss.php?texttype=4";
	private static $fzRSS = "http://www.fz.se/core/rss/fznews_rss20.xml";
    
    private $rssFeedArray = array();
    
    
    public function loadRSSFeed() {
        
        $rss = new DOMDocument();
        $rss -> load(self::$fzRSS);
        
        $feed = array();
		
        foreach ($rss -> getElementsByTagName('item') as $node) {
	    
    	    $item = array (
    	        
				// The first 4 tags are pretty common xml-tags in rss-feeds.
    		    'title' => $node -> getElementsByTagName('title') -> item(0) -> nodeValue,
    		    'desc' => $node -> getElementsByTagName('description') -> item(0) -> nodeValue,
    		    'link' => $node -> getElementsByTagName('link') -> item(0) -> nodeValue,
    		    'date' => $node -> getElementsByTagName('pubDate') -> item(0) -> nodeValue,
				
				// Not all rss-feeds got these tags. Therefore check if they exist - if not, return empty string.
				'image' => $node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue ? $node -> getElementsByTagName('imgUrl') -> item(0) -> nodeValue : '',
		    );
    		
    	    array_push($feed, $item);
        }
        
        $this -> rssFeedArray = $feed;
    }
    
    public function getRSSFeedArray() {
        
        return $this -> rssFeedArray;
    }
    
}