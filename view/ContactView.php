<?php

class ContactView {
	
	private static $contactForm = "ContactView::ContactForm";
	
	private static $name = "ContactView::Name";
	private static $email = "ContactView::Email";
	private static $message = "ContactView::Message";
	private static $send = "ContactView::Send";
	
	private $from = 'From: TestUser'; 
    private $to = 'wictor.kihlbaum@gmail.com'; 
    private $subject = 'Hello';
	

	public function response() {
		
		return $this -> renderTopic() . $this -> generateContactFormHTML();
	}
	
	private function renderTopic() {
	
		return '
			<h2>Contact me</h2>
		';	
	}
	
	private function generateContactFormHTML() {
	
		return '
			<div id="contactForm">
				<form method="post" name="'. self::$contactForm .'">
			
					<label>Name</label>
					<input name="'. self::$name .'" type="text">
							
					<label>Email</label>
					<input name="'. self::$email .'" type="email">
							
					<label>Message</label>
					<textarea name="'. self::$message .'"></textarea>
							
					<input id="submit" name="'. self::$send .'" type="submit" value="Send message">
						
				</form>
			</div>
		';	
	}
	
	public function getEmailContent() {
	
		return 'From: '. $this -> getRequestName() .'\n E-Mail: '. $this -> getRequestEmail() .'\n Message:\n '. $this -> getRequestMessage() .'';
	}
	
	private function getRequestName() {
		
		if (isset($_POST[self::$name])) {
			
			return $_POST[self::$name];
		}
			
		return '';
	}
	
	private function getRequestEmail() {
		
		if (isset($_POST[self::$email])) {
			
			return $_POST[self::$email];
		}
			
		return '';
	}
	
	private function getRequestMessage() {
		
		if (isset($_POST[self::$message])) {
			
			return $_POST[self::$message];
		}
			
		return '';
	}
	
	public function didUserPressSend() {
		
		return isset($_POST[self::$send]);
	}
}