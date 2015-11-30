<?php

class HomeView {
	
	private $sessionModel;
	private $siteArray;
	private $serviceModel;
	
	
	public function __construct($sessionModel, $serviceModel) {
		
		$this -> sessionModel = $sessionModel;
		$this -> serviceModel = $serviceModel;
	}

	public function response() {
		
		return 
			$this -> renderSubTopicAndImage() .
			$this -> renderFavoriteGamesiteNews() .
			$this -> renderTopNews();
	}
	
	private function renderFavoriteGamesiteNews() {
	
		return '
			<div id="favorite-gamesite-news">
				'. $this -> renderContent() .'
			</div>
		';	
	}
	
	private function renderContent() {
	
		if ($this -> sessionModel -> getUserSession()) {
			
			return 'User is logged in. Show favorite site news';
		}
		
		return 'User is not logged in';
	}
	
	private function renderTopNews() {
	
		$amountOfSites = 0;
		$containers = '';
		
		foreach ($this -> siteArray as $site) {
			
			//if ($amountOfSites == 3) break;
			//$amountOfSites += 1;
			
			$news = $site -> getNews();
			$latestArticle = $news[0];
			
			$containers .= '
				<div class="topNewsContainer">
					<p class="article-site-name">Latest '. $site -> getSiteName() .' Article</p>
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