<?php

class NewsfeedModel {
    
    private static $aftonbladetRSS = "http://www.aftonbladet.se/rss.xml";
    private static $expressenRSS = "http://expressen.se/rss/nyheter";
    private static $svdRSS = "http://www.svd.se/?service=rss";
    private static $svtRSS = "http://www.svt.se/nyheter/rss.xml";
    
    private $rssFeedArray = array();
    
    
    public function loadRSSFeed() {
        
        $rss = new DOMDocument();
        $rss -> load(self::$aftonbladetRSS);
        
        $feed = array();
        
        foreach ($rss -> getElementsByTagName('item') as $node) {
	    
    	    $item = array (
    	        
    		    'title' => $node -> getElementsByTagName('title') -> item(0) -> nodeValue,
    		    'desc' => $node -> getElementsByTagName('description') -> item(0) -> nodeValue,
    		    'link' => $node -> getElementsByTagName('link') -> item(0) -> nodeValue,
    		    'date' => $node -> getElementsByTagName('pubDate') -> item(0) -> nodeValue,
    		    //'image' => $node -> getElementsByTagName('thumbnail') -> item(0) ? $node -> getElementsByTagName('thumbnail') -> item(0) -> getAttribute('url') : 'No image',
		    );
    		
    	    array_push($feed, $item);
        }
        
        $this -> rssFeedArray = $feed;
    }
    
    public function getRSSFeedArray() {
        
        return $this -> rssFeedArray;
    }
    
}