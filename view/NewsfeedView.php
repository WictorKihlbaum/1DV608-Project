<?php

class NewsfeedView {
	
	private $sessionModel;
	private $siteArray;
	private $defaultNewsLimit = 5;
	private $defaultSiteLimit = 2;
    
	private static $newsList = 'NewsfeedView::NewsList';
	private static $siteList = 'NewsfeedView::SiteList';
	private static $updateSettingsList = 'NewsfeedView::UpdateSettingsList';
	private static $rssList = 'NewsfeedView::RssList';
	private static $updateGamesite = 'NewsfeedView::UpdateGamesite';
	
	
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
		
		$amountOfContainers = 0; // Number of sites the user wants to see.
		$containers = '';
	
		foreach ($this -> siteArray as $site) {
			
			if ($amountOfContainers == $this -> sessionModel -> getNumberOfSitesSession()) break;
			$amountOfContainers += 1;
			
			$siteName = $site -> getSiteName();
			$news = $site -> getNews();
			
			$containers .= '
				<div class="feedContainer" id="'. $siteName .'">
					<form method="post">
						<label for="'. self::$rssList .'">Gamesite:</label>
						<select name="'. self::$rssList .'">
							'. $this -> getSiteNameOptions($siteName) .'
						</select>
						<input type="submit" value="Change" name="'. self::$updateGamesite .'">
					</form>
					'. $this -> renderContent($news) .'
				</div>';
		}
		
		return $containers;
	}
	
	private function getSiteNameOptions($siteName) {
		
		$options = '';
		
		foreach ($this -> siteArray as $site) {
			
			$name = $site -> getSiteName();
			$options .= '
				<option value="'. $name .'" '. $this -> selectSite($siteName, $name) .'>'. $name .'</option>
			';
		}
		
		return $options;
	}
	
	private function selectSite($siteName, $name) {
		
		if ($siteName == $name) {
		
			return 'selected';
		}
		
		return '';
	}
	
	private function renderContent($news) {
		
		$amountOfContent = 0; // Number of news per site the user wants to see.
		$content = '';
		
		foreach ($news as $article) {
			
			if ($amountOfContent == $this -> sessionModel -> getNumberOfNewsSession()) break;
			$amountOfContent += 1;
				
			$title = str_replace(' & ', ' &amp; ', $article -> getTitle());
			$link = $article -> getLink();
			$image = $article -> getImgUrl();
			$description = $article -> getDescription();
			$date = date('l F d, Y', strtotime($article -> getPubDate()));
					
			$content .= 		
				'<div class="feedContent">' .
					$this -> renderArticleLinkWithTitle($title, $link) .
					$this -> renderArticleDate($date) .
					$this -> renderArticleImage($image) .
					$this -> renderArticleDescription($description) .
				'</div>';
		}
		
		return $content;
	}
	
	private function renderSettings() {
	
		return '
			<div id="newsfeedForm">
			<p>
				Change these settings to show the news however you like them.<br />
				Press the orange topic to read the complete article.
			</p>
			
				<form method="post">
				
					<div class="settingsColumn">
						<label for="'. self::$siteList .'">Show:</label>
						<select name="'. self::$siteList .'">
							'. $this -> getSiteLimitOptions() .'
						</select>
					</div>
					
					<div class="settingsColumn">
						<label for="'. self::$newsList .'">News per site:</label>
						<select name="'. self::$newsList .'">
							'. $this -> getNewsLimitOptions() .'
						</select>
					</div>
					
					<input type="submit" value="Update settings" name="'. self::$updateSettingsList .'">
					
				</form>
			</div>
		';
	}
	
	private function getSiteLimitOptions() {
		
		$maxLimit = sizeof($this -> siteArray);
		$options = '';
	
		for ($i = 2; $i <= $maxLimit; $i += 2) {
			
			$options .= '
				<option value="'. $i .'" '. $this -> checkSiteValue($i) .'>'. $i .' sites</option>
			';
		}
		
		return $options;
	}
	
	private function getNewsLimitOptions() {
	
		$maxLimit = 20;
		$options = '';
		
		for ($i = 5; $i <= $maxLimit; $i += 5) {
			
			$options .= '
				<option value="'. $i .'" '. $this -> checkNewsValue($i) .'>'. $i .'</option>
			';
		}
		
		return $options;
	}
	
	private function renderArticleLinkWithTitle($title, $link) {
	
		return '<p><strong><a href="'. $link .' title="'. $title .'">'. $title .'</a></strong></p>';
	}
	
	private function renderArticleDate($date) {
		
		return '<small>Posted on '. $date .'</small>';
	}
	
	private function renderArticleImage($image) {
		
		if ($image != '') {
			
			return '<p><img src="'. $image .'"></p>';
		}
	
		return null;
	}
	
	private function renderArticleDescription($description) {
	
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
		
		} else if ($this -> sessionModel -> isNumberOfNewsSessionSet()) {
			
			return $this -> sessionModel -> getNumberOfNewsSession();
		}
		
		return $this -> defaultNewsLimit;
	}
	
	public function getLimitOfSites() {
		
		if (isset($_POST[self::$siteList])) {
			
			return $_POST[self::$siteList];     
		
		} else if ($this -> sessionModel -> isNumberOfSitesSessionSet()) {
			
			return $this -> sessionModel -> getNumberOfSitesSession();
		}
		
		return $this -> defaultSiteLimit;
	}
    
}