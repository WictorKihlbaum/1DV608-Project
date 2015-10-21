<?php

class ContactView {
	
	private static $contactForm = "ContactView::ContactForm";
	
	private $errorMessageTopic = "An error occurred. One or more fields haven't been typed in.";
	private $successMessageTopic = 'Success!';
	private $feedbackMessage = '';
	private static $nameFieldIsEmptyMessage = 'No name has been typed in.';
	private static $emailFieldIsEmptyMessage = 'No email has been typed in.';
	private static $messageFieldIsEmptyMessage = 'No message has been typed in.';
	private static $messageSentSuccessfullyMessage = 'Message has been sent successfully!';
	
	private static $name = "ContactView::Name";
	private static $email = "ContactView::Email";
	private static $subjectList = "ContactView::SubjectList";
	private static $message = "ContactView::Message";
	private static $send = "ContactView::Send";
	

	public function response() {
		
		return 
			$this -> renderTopic() . 
			$this -> generateContactFormHTML() .
			$this -> showFeedbackMessage();
	}
	
	private function showFeedbackMessage() {
		
		/*
		switch ($this -> feedbackMessage) {
			
			case '': return null;
			
			case self::$messageSentSuccessfullyMessage:
				return '
					<div id="successMessageContainer">
						<p>'. $this -> successMessageTopic .'</p>
						<p>'. $this -> feedbackMessage .'</p>
					</div>
				';
				
			default:
				return '
					<div id="errorMessageContainer">
						<p>'. $this -> errorMessageTopic .'</p>
						<p>'. $this -> feedbackMessage .'</p>
					</div>
				';
		}
		*/
		
		return '
			
				<p>'. $this -> feedbackMessage .'</p>
			
		';
		
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
					<input name="'. self::$name .'" value="'. $this -> getRequestName() .'" type="text">
							
					<label>Email</label>
					<input name="'. self::$email .'" value="'. $this -> getRequestEmail() .'" type="email">
					
					<label for="'. self::$subjectList .'">Subject:</label>
					<select name="'. self::$subjectList .'">
						<option value="Report bugs/errors">Bugs/Errors</option>
						<option value="Improvement suggestions">Improvement suggestions</option>
						<option value="Other">Other</option>
					</select>
							
					<label>Message</label>
					<textarea name="'. self::$message .'" value="'. $this -> getRequestMessage() .'"></textarea>
							
					<input id="submit" name="'. self::$send .'" type="submit" value="Send message">
						
				</form>
			</div>
		';	
	}
	
	public function getEmailContent() { // TODO: Add Spam protection.
		
		try {
		
			if ($this -> getRequestName() == '') {
				
				throw new \NameFieldIsEmptyException();
			
			} else if ($this -> getRequestEmail() == '') {
				
				throw new \EmailFieldIsEmptyException();
				
			} else if ($this -> getRequestMessage() == '') {
				
				throw new \MessageFieldIsEmptyException();
			}
			
			// Return message if everything is typed in correctly.
			return new EmailModel(
				$this -> getRequestName(), 
				$this -> getRequestEmail(), 
    			$this -> getRequestSubject(), 
				$this -> getRequestMessage())
			;
			
		} catch (NameFieldIsEmptyException $e) {
			
			$this -> setFeedbackMessage(self::$nameFieldIsEmptyMessage);
			
		} catch (EmailFieldIsEmptyException $e) {
			
			$this -> setFeedbackMessage(self::$emailFieldIsEmptyMessage);
			
		} catch (MessageFieldIsEmptyException $e) {
			
			$this -> setFeedbackMessage(self::$messageFieldIsEmptyMessage);
		}
	}
	
	private function setFeedbackMessage($feedbackMessage) {
		
		$this -> feedbackMessage = $feedbackMessage;
	}
	
	public function setMessageSentSuccessfullyFeedbackMessage() {
		
		$this -> setFeedbackMessage(self::$messageSentSuccessfullyMessage);
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
	
	private function getRequestSubject() {
	
		return $_POST[self::$subjectList];	
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