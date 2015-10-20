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
		
		$hejsan = $this -> contactView -> getEmailContent();
		
		if ($this -> contactView -> didUserPressSend()) {
			
			
			echo 'test';
				
			/*
			$to = 'wictor.kihlbaum@gmail.com';
			$subject = $this -> contactView -> getRequestSubject();
			$message = $this -> contactView -> getEmailContent();
			$headers = 'From: '. $this -> contactView -> getRequestEmail() . '\r\n' .
					   'Reply-To: '. $this -> contactView -> getRequestEmail() . '\r\n' .
					   'X-Mailer: PHP/' . phpversion();
			
			
			if (mail($to, $subject, $message, $headers)) { 
			
				//echo '<p>Your message has been sent!</p>';
				//mail($to, $subject, $message, $headers);
				$this -> contactView -> setMessageSentSuccessfullyFeedbackMessage();
				
			} else { 
				
				echo '<p>Something went wrong, go back and try again!</p>'; 
			}
			*/
		}
	}
	
}