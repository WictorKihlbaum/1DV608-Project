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
			
			$email = $this -> contactView -> getEmailContent();
			
			if ($email != null) {
				
				//ini_set('SMTP','acsm_9268280c21a7845');
				//ini_set('smtp_port', 25);
				
				$message = $email -> getMessage();
				$to = 'wictor.kihlbaum@gmail.com';
				$subject = $email -> getSubject();
				$headers = 'From: '. $email -> getName() . '\r\n' .
						   'Reply-To: '. $email -> getEmail() . '\r\n' .
						   'X-Mailer: PHP/' . phpversion();
						   
				
				if (mail($to, $subject, $message, $headers)) { 
				
					//echo '<p>Your message has been sent!</p>';
					//mail($to, $subject, $message, $headers);
					$this -> contactView -> setMessageSentSuccessfullyFeedbackMessage();
					
				} else { 
					
					echo '<p>Something went wrong, go back and try again!</p>'; 
				}		   
			}
		}
	}
	
}