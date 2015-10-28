<?php

class ContactController {
	
	private $contactView;
	private $contactModel;
	
	
	public function __construct($contactView, $contactModel) {
	
		$this -> contactView = $contactView;	
		$this -> contactModel = $contactModel;
	}
	
	public function reforwardDidUserPressSend() {
	
		return $this -> contactView -> didUserPressSend();	
	}
	
	public function handleContactForm() {
		
		try {
		
			if ($this -> contactView -> didUserPressSend()) {
				
				$email = $this -> contactView -> getEmailContent();
				$this -> contactModel -> sendEmail($email);
				// Set feedbackmessage if email was sent.
				$this -> contactView -> setMessageSentSuccessfullyFeedbackMessage();
			}
			
		} catch (EmailNotSentException $e) {
		
			$this -> contactView -> setMessageNotSentFeedbackMessage();
		}
	}
	
}