<?php

class HomeView {

	public function response() {
		
		return '
			'. $this -> renderTopic() .'
		';
		
	}
	
	private function renderTopic() {
	
		return '<h1>Welcome to Gamefeed</h1>';
	}
}