<?php

class NewsfeedView {
	
	private $sessionModel;
    
	private static $newsList = "NewsfeedView::NewsList";
	private static $siteList = "NewsfeedView::SiteList";
	private static $updateSettingsList = "NewsfeedView::UpdateSettingsList";
	private static $rssList = "NewsfeedView::RssList";
	private static $updateGamesite = "NewsfeedView::UpdateGamesite";
	private $defaultNewsLimit = 5;
	private $defaultSiteLimit = 2;
	
	private $siteArray;
	private $newsfeed = '';	
	
	
	public function __construct($sessionModel) {
		
		$this -> sessionModel = $sessionModel;
	}
	
	public function response() {
	
		return '
			<h1>Newsfeed</h1> ' .
			$this -> renderSettings() .
			$this -> renderContainers();
	}
	
	public function setSiteArray($siteArray) {
		
		$this -> siteArray = $siteArray;
	}
	
	public function renderContainers() {
		
		$containers = '';
	
		foreach ($this -> siteArray as $site) {
			
			$news = $site -> getNews();
			
			$containers .= '
				<div class="feedContainer" id="'. $site -> getSiteName() .'">
					<form method="post">
						<label for="'. self::$rssList .'">Gamesite:</label>
						<select name="'. self::$rssList .'">
							<option value="1">Gamereactor</option>
							<option value="2">FZ</option>
							<option value="3">Something</option>
						</select>
						<input type="submit" value="Update" name="'. self::$updateGamesite .'">
					</form>
					'. $this -> getContent($news) .'
				</div>';
		}
		
		return $containers;
	}
	
	private function getContent($news) {
		
		$content = '';
		
		foreach ($news as $article) {
				
			$title = str_replace(' & ', ' &amp; ', $article -> getTitle());
			$link = $article -> getLink();
			$description = $article -> getDescription();
			$date = date('l F d, Y', strtotime($article -> getPubDate()));
					
			$content .= 		
				'<div class="feedContent">' .
					$this -> renderLinkWithTitle($title, $link) .
					$this -> renderDate($date) .
					$this -> renderDescription($description) .
				'</div>';
		}
		
		return $content;
	}
	
	private function renderFeedContainers() {
		
		$feedContainers = '';
		
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
					</form>
					
					'. $this -> newsfeed .'
				</div>';
		}
		
		return $feedContainers;
	}
	
	public function renderRSSFeed($feedArrays) {
	
		foreach ($feedArrays as $feedArray) {
			
			$feedContainerClass = '';
			
			foreach ($feedArray as $article) {
				
				$feedContentClass = '';
				
				$title = str_replace(' & ', ' &amp; ', $feedArray[$i] -> getTitle());
				$link = $feedArray[$i] -> getLink();
				$description = $feedArray[$i] -> getDescription();
				$date = date('l F d, Y', strtotime($feedArray[$i] -> getPubDate()));
				//$image = $feedArray[$i][$item -> getImgUrl()];
					
				$feedContentClass .= 		
					'<div class="feedContent">' .
						$this -> renderLinkWithTitle($title, $link) .
						$this -> renderDate($date) .	
						/*$this -> renderImage($image) .*/	
						$this -> renderDescription($description) .
					'</div>';
			}
		}
		
		
			//$feed = '';	
//				
//			$limit = $this -> getLimitOfNews();	
//		
//			for ($i = 0; $i < $limit; $i++) {
//				
//				$title = str_replace(' & ', ' &amp; ', $feedArray[$i] -> getTitle());
//				$link = $feedArray[$i] -> getLink();
//				$description = $feedArray[$i] -> getDescription();
//				$date = date('l F d, Y', strtotime($feedArray[$i] -> getPubDate()));
//				//$image = $feedArray[$i][$item -> getImgUrl()];
//					
//				$feed .= 		
//					'<div class="feedContent">' .
//						$this -> renderLinkWithTitle($title, $link) .
//						$this -> renderDate($date) .	
//						/*$this -> renderImage($image) .*/	
//						$this -> renderDescription($description) .
//					'</div>';
//					
//				$this -> newsfeed = $feed;
//			}
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
	
	private function renderLinkWithTitle($title, $link) {
	
		return '<p><strong><a href="'. $link .' title="'. $title .'">'. $title .'</a></strong></p>';
	}
	
	private function renderDate($date) {
		
		return '<small>Posted on '. $date .'</small>';
	}
	
	private function renderImage($image) {
		
		if ($image != '') {
			
			return '<p><img src="'. $image .'"></p>';
		}
	
		return null;
	}
	
	private function renderDescription($description) {
	
		return '<p>'. $description .'</p>';	
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