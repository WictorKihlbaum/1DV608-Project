<?php

class NewsfeedView {
    
    private $newsfeed = "";
    
    
    public function getNewsFeed() {
        
        return $this -> newsfeed;
    }
    
    public function setNewsfeed($newsfeed) {
        
        $this -> newsfeed = $newsfeed;
    }
    
}