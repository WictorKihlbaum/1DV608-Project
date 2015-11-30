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
			
			$favorite = $this -> serviceModel -> getFavoriteGamesiteForLoggedInUser();
			$news = array();
			
			if ($favorite == null || $favorite == '') {
				
				return 'To see the latest news from your favorite gamesite 
						you need to add one. Visit "Login" to add one site as your favorite.';
			}
			
			foreach ($this -> siteArray as $site) {
				
				if ($site -> getSiteName() == $favorite) {
					$news[] = $site -> getNews();
				}
			}
			
			return $this -> renderFavoriteGamesiteNews($news);
		}
		
		return 'If you are a registered user you will in this field 
				be able to read the latest news from your favorite gamesite. 
				Please register an account and add your favorite site.';
	}
	
	private function renderFavoriteGamesiteNews($news) {
	
		$containers = '';
		
		foreach ($news as $article) {
			
			$containers .= '
				<div class="topNewsContainer">
					'. $this -> renderArticle($article) .'
				</div>
			';
		}
		
		return $containers;
	}
	
	private function renderTopNews() {
	
		$containers = '';
		
		foreach ($this -> siteArray as $site) {
			
			$news = $site -> getNews();
			$latestArticle = $news[0];
			
			$containers .= '
				<div class="topNewsContainer">
					<p class="article-site-name">Latest '. $site -> getSiteName() .' Article</p>
					'. $this -> renderArticle($latestArticle) .'
				</div>';
		}
		
		return $containers;
	}
	
	private function renderArticle($article) {
	
			$title = str_replace(' & ', ' &amp; ', $article -> getTitle());
			$link = $article -> getLink();
			$image = $article -> getImgUrl();
			$description = $article -> getDescription();
			$date = date('l F d, Y', strtotime($article -> getPubDate()));
					
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