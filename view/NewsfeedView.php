<?php

class NewsfeedView {
	
	private $sessionModel;
    
	private static $newsList = "NewsfeedView::NewsList";
	private static $siteList = "NewsfeedView::SiteList";
	private static $updateSettingsList = "NewsfeedView::UpdateSettingsList";
    private $newsfeed = "";
	private $defaultNewsValue = 5;
	private $defaultSiteValue = 2;
	
	
	public function __construct($sessionModel) {
		
		$this -> sessionModel = $sessionModel;
	}
	
	public function response() {
	
		return '
			<h1>Newsfeed</h1>
			
			'. $this -> renderSettings() .'
			'. $this -> renderFeedContainers() .'
		';	
	}
	
	private function renderFeedContainers() {
		
		$feedContainers = "";
		
		for ($i = 0; $i < $this -> sessionModel -> getNumberOfSitesSession(); $i++) {
			
			$feedContainers .= '<div class="feedContainer">'. $this -> getNewsFeed() . '</div>';
		}
		
		return $feedContainers;
	}
	
	private function renderSettings() {
	
		return '
			<div id="newsfeedForm">
				<form method="post">
					
					<div class="settingsColumn">
						<label for="'. self::$newsList .'">News:</label>
						<select name="'. self::$newsList .'">
							<option value="5" '. $this -> checkNewsValue(5) .'>5</option>
							<option value="10" '. $this -> checkNewsValue(10) .'>10</option>
							<option value="15" '. $this -> checkNewsValue(15) .'>15</option>
						</select>
					</div>
					
					<div class="settingsColumn">
						<label for="'. self::$siteList .'">Sites:</label>
						<select name="'. self::$siteList .'">
							<option value="2" '. $this -> checkSiteValue(2) .'>2</option>
							<option value="4" '. $this -> checkSiteValue(4) .'>4</option>
							<option value="6" '. $this -> checkSiteValue(6) .'>6</option>
						</select>
					</div><br />
					
					<input type="submit" value="Update" name="'. self::$updateSettingsList .'">
				</form>
			</div>
		';
	}
    
    public function getNewsFeed() {
			
        return $this -> newsfeed;
    }
    
    private function setNewsfeed($newsfeed) {
        
        $this -> newsfeed = $newsfeed;
    }
	
	public function renderRSSFeed($feed) {
        
        $newsfeed = "";
		$limit = $this -> getLimitOfNews();
        
        for ($x = 0; $x < $limit; $x++) {
            
        	//$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']); Need?
			$title = $feed[$x]['title'];
        	$link = $feed[$x]['link'];
        	$description = $feed[$x]['desc'];
        	$date = date('l F d, Y', strtotime($feed[$x]['date']));
        	//$image = $feed[$x]['image'];
        	
        	$newsfeed .= '<div class="feedContent"><p><strong><a href="'. $link .' title="'. $title .'">'. $title .'</a></strong><br />' .
        	'<small>Posted on '. $date .'</small></p>'.
        	'<p>'. $description .'</p></div>';
        	
        	//'<img src="'.$image.'">' . 
        	// ^Put this before the 'p'-tag above.
        }
		
        $this -> setNewsfeed($newsfeed);
	}
	
	public function didUserPressUpdate() {
	
		return isset($_POST[self::$updateSettingsList]);
	}
	
	private function checkNewsValue($value) {
		
		if ($this -> sessionModel -> isNumberOfNewsSessionSet()) {
			
			if ($this -> sessionModel -> getNumberOfNewsSession() == $value) {
				
				return 'selected';
			
			} else {
			
				return '';	
			}
		}
		
		return $this -> defaultNewsValue;
	}
	
	private function checkSiteValue($value) {
		
		if ($this -> sessionModel -> isNumberOfSitesSessionSet()) {
			
			if ($this -> sessionModel -> getNumberOfSitesSession() == $value) {
				
				return 'selected';
			
			} else {
			
				return '';	
			}
		}
		
		return $this -> defaultSiteValue;
	}
	
	public function getLimitOfNews() {
		
		if (isset($_POST[self::$newsList])) {
			
			return $_POST[self::$newsList];     
		}
		
		return $this -> defaultNewsValue;
	}
	
	public function getLimitOfSites() {
		
		if (isset($_POST[self::$siteList])) {
			
			return $_POST[self::$siteList];     
		}
		
		return $this -> defaultSiteValue;
	}
    
}