<?php

class HomeView {

	public function response() {
		
		return 
			$this -> renderTopic() .
			$this -> renderTopNews();
	}
	
	private function renderTopic() {
		
		return '<h1>Welcome to Gamefeed</h1>';
	}
	
	private function renderTopNews() {
	
		$divs = '';
	
		for ($i = 0; $i <= 4; $i++) {
			
			$divs .= '
				<div class="topNews">
				</div>
			';
		}
		
		return $divs;
	}
}