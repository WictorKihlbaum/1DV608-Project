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
				
				/*$url = 'https://api.sendgrid.com/';
				$user = 'azure_470730f159f6d62fbb429813ff905ef9@azure.com';
				$pass = 'cv5J892HoHx15Nz';
				
				$params = array(
					'api_user'  => $user,
					'api_key'   => $pass,
					'to'        => 'wictor.kihlbaum@gmail.com',
					'subject'   => 'testing from curl',
					'html'      => 'testing body',
					'text'      => 'testing body',
					'from'      => 'example@sendgrid.com',
				  );
				
				
				$request =  $url.'api/mail.send.json';
				
				// Generate curl request
				$session = curl_init($request);
				// Tell curl to use HTTP POST
				curl_setopt ($session, CURLOPT_POST, true);
				// Tell curl that this is the body of the POST
				curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
				// Tell curl not to return headers, but do return the response
				curl_setopt($session, CURLOPT_HEADER, false);
				// Tell PHP not to use SSLv3 (instead opting for TLS)
				curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
				
				// obtain response
				$response = curl_exec($session);
				curl_close($session);
				
				// print everything out
				print_r($response);*/
				
				ini_set("SMTP","smtp.gmail.com" ); 
				ini_set("smtp_port","465");
				
				$message = $email -> getMessage();
				$to = 'wictor.kihlbaum@gmail.com';
				$subject = $email -> getSubject();
				$headers = 'From: '. $email -> getName() . '\r\n' .
						   'Reply-To: '. $email -> getEmail() . '\r\n' .
						   'X-Mailer: PHP/' . phpversion();
				
						   
				
				if (mail($to, $subject, $message, $headers)) { 
				
					echo '<p>Your message has been sent!</p>';
					//mail($to, $subject, $message, $headers);
					$this -> contactView -> setMessageSentSuccessfullyFeedbackMessage();
					
				} else { 
					
					echo '<p>Something went wrong, go back and try again!</p>'; 
				}		   
			}
		}
	}
	
}