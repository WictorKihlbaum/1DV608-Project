<?php

class HomeView {
	
	private $sessionModel;
	private $siteArray;
	
	
	public function __construct($sessionModel) {
		
		$this -> sessionModel = $sessionModel;
	}

	public function response() {
		
		return 
			$this -> renderSubTopicAndImage() .
			$this -> renderTopNews();
	}
	
	private function renderTopic() {
		
		return '<h1>Welcome to Gamefeed</h1>';
	}
	
	private function renderTopNews() {
	
		$amountOfSites = 0;
		$containers = '';
		
		foreach ($this -> siteArray as $site) {
			
			if ($amountOfSites == 3) break;
			$amountOfSites += 1;
			
			$news = $site -> getNews();
			$latestArticle = $news[0];
			
			$containers .= '
				<div class="topNewsContainer">
					'. $this -> renderTopArticle($latestArticle) .'
				</div>';
		}
		
		return $containers;
	}
	
	private function renderTopArticle($latestArticle) {
	
			$title = str_replace(' & ', ' &amp; ', $latestArticle -> getTitle());
			$link = $latestArticle -> getLink();
			$image = $latestArticle -> getImgUrl();
			$description = $latestArticle -> getDescription();
			$date = date('l F d, Y', strtotime($latestArticle -> getPubDate()));
					
			return
				'<div class="textWrap">' .
					$this -> renderArticleLinkWithTitle($title, $link) .
					$this -> renderArticleDate($date) .
					$this -> renderArticleDescription($description) .
				'</div>' .
					$this -> renderArticleImage($image);	
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
	
	private function renderSubTopicAndImage() {
	
		return '
			<div id="subTopicAndImage"></div>
		';		
	}
	
	public function setSiteArray($siteArray) {
		
		$this -> siteArray = $siteArray;
	}
	
}