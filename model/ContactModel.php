<?php 

class ContactModel {

	private $email;
	
	
	public function	 sendEmail($email) {
		
		// The use of libraries is not allowed.
		
		/* This code works great IF I have a local SMTP-server which I'm using.
		   However, in order to send email throw a public SMTP-server I would have to
		   use one of the many libraries which come along it. Unfortuneatly I discovered
		   this a bit to late. */
		
		if ($email != null) { 
			
			$message = $email -> getMessage();
			$to = 'wictor.kihlbaum@gmail.com';
			$subject = $email -> getSubject();
			$headers = 'From: '. $email -> getName() . '\r\n' .
					   'Reply-To: '. $email -> getEmail() . '\r\n' .
					   'X-Mailer: PHP/' . phpversion();
			
			
			if (mail($to, $subject, $message, $headers)) { 
			
				mail($to, $subject, $message, $headers);
				
			} else { 
				
				throw new \EmailNotSentException();
			}	   
		}
	}
	
}