<?php

class ContactController {
	
	private $contactView;
	
	
	public function __construct($contactView) {
	
		$this -> contactView = $contactView;	
	}
	
	public function reforwardDidUserPressSend() {
	
		return $this -> contactView -> didUserPressSend();	
	}
	
	public function handleContactForm() {
		
		if ($this -> contactView -> didUserPressSend()) {
				
			$from = "From: TestUser";
			$to = "wictor.kihlbaum@gmail.com";
			$subject = "Hello";
				
			if (mail ($to, $subject, $this -> contactView -> getEmailContent(), $from)) { 
			
				echo '<p>Your message has been sent!</p>';
				$this -> contactView -> setMessageSentSuccessfullyFeedbackMessage();
				
			} else { 
				
				echo '<p>Something went wrong, go back and try again!</p>'; 
			}
		}
	}
	
}