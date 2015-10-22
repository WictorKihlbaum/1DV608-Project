<?php

class NewsfeedView {
	
	private $sessionModel;
    
	private static $newsList = "NewsfeedView::NewsList";
	private static $siteList = "NewsfeedView::SiteList";
	private static $updateSettingsList = "NewsfeedView::UpdateSettingsList";
	private static $rssList = "NewsfeedView::RssList";
	private static $updateGamesite = "NewsfeedView::UpdateGamesite";
    private $newsfeed = "";
	private $defaultNewsLimit = 5;
	private $defaultSiteLimit = 2;
	
	
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
			
			$feedContainers .= '
				<div class="feedContainer">
					<form method="post">
						<label for="'. self::$rssList .'">Gamesite:</label>
						<select name="'. self::$rssList .'">
							<option value="1">Gamereactor</option>
							<option value="2">FZ</option>
							<option value="3">Something</option>
						</select>
						<input type="submit" value="Update" name="'. self::$updateGamesite .'">
						'. $this -> getNewsFeed() .'
					</form>
				</div>';
		}
		
		return $feedContainers;
	}
	
	private function renderSettings() {
	
		return '
			<div id="newsfeedForm">
			<p>Change these settings to show the news however you like them.<br />Press the orange topic to read the complete article.</p>
			
				<form method="post">
				
				<div class="settingsColumn">
						<label for="'. self::$siteList .'">Show:</label>
						<select name="'. self::$siteList .'">
							<option value="2" '. $this -> checkSiteValue(2) .'>2 sites</option>
							<option value="4" '. $this -> checkSiteValue(4) .'>4 sites</option>
							<option value="6" '. $this -> checkSiteValue(6) .'>6 sites</option>
						</select>
					</div>
					
					<div class="settingsColumn">
						<label for="'. self::$newsList .'">News per site:</label>
						<select name="'. self::$newsList .'">
							<option value="5" '. $this -> checkNewsValue(5) .'>5</option>
							<option value="10" '. $this -> checkNewsValue(10) .'>10</option>
							<option value="15" '. $this -> checkNewsValue(15) .'>15</option>
						</select>
					</div>
					
					<input type="submit" value="Update settings" name="'. self::$updateSettingsList .'">
					
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
        
        $newsfeed = '';
		$limit = $this -> getLimitOfNews();
        
        for ($x = 0; $x < $limit; $x++) {
            
        	$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
        	$link = $feed[$x]['link'];
        	$description = $feed[$x]['desc'];
        	$date = date('l F d, Y', strtotime($feed[$x]['date']));
        	//$image = $feed[$x]['image'];
        	
        	$newsfeed .= 
			
			'<div class="feedContent">
				<p>
					<strong><a href="'. $link .' title="'. $title .'">'. $title .'</a></strong><br />' .
        			'<small>Posted on '. $date .'</small>
				</p>'.
        		'<p>'. $description .'</p>
			</div>';
        	
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
			}
		}
		
		return '';	
	}
	
	private function checkSiteValue($value) {
		
		if ($this -> sessionModel -> isNumberOfSitesSessionSet()) {
			
			if ($this -> sessionModel -> getNumberOfSitesSession() == $value) {
				
				return 'selected';
			} 
		}
		
		return '';
	}
	
	public function getLimitOfNews() {
		
		if (isset($_POST[self::$newsList])) {
			
			return $_POST[self::$newsList];     
		}
		
		return $this -> defaultNewsLimit;
	}
	
	public function getLimitOfSites() {
		
		if (isset($_POST[self::$siteList])) {
			
			return $_POST[self::$siteList];     
		}
		
		return $this -> defaultSiteLimit;
	}
    
}