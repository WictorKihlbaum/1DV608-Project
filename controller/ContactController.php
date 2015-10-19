<?php

class ContactController {
	
	private $contactView;
	
	
	public function __construct($contactView) {
	
		$this -> contactView = $contactView;	
	}
	
	public function handleContactForm() {
		
		if ($this -> contactView -> didUserPressSend()) {
			
			$from = "From: TestUser";
			$to = "wictor.kihlbaum@gmail.com";
			$subject = "Hello";
			
			if (mail ($to, $subject, $this -> contactView -> getEmailContent(), $from)) { 
			
				echo '<p>Your message has been sent!</p>';
				
			} else { 
			
				echo '<p>Something went wrong, go back and try again!</p>'; 
			}
		}
	}
	
}