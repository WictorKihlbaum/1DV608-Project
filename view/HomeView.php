<?php

class HomeView {
	
	private $sessionModel;
	private $siteArray;
	
	
	public function __construct($sessionModel) {
		
		$this -> sessionModel = $sessionModel;
	}

	public function response() {
		
		return 
			$this -> renderTopic() .
			$this -> renderSubTopicAndImage() .
			$this -> renderTopNews();
	}
	
	private function renderTopic() {
		
		return '<h1>Welcome to Gamefeed</h1>';
	}
	
	private function renderTopNews() {
	
		$divs = '';
	
		for ($i = 1; $i <= 3; $i++) {
			
			$divs .= '
				<div class="topNews">
				</div>
			';
		}
		
		return $divs;
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