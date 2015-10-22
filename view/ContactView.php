<?php

class ContactView {
	
	private $errorMessageTopic = "An error occurred. One or more fields haven't been typed in.";
	private $successMessageTopic = 'Success!';
	private $feedbackMessage = '';
	private static $nameFieldIsEmptyMessage = 'No name has been typed in.';
	private static $emailFieldIsEmptyMessage = 'No email has been typed in.';
	private static $messageFieldIsEmptyMessage = 'No message has been typed in.';
	private static $wrongAntiSpamAnswerMessage = 'The anti-spam answer was wrong.';
	private static $messageSentSuccessfullyMessage = 'Message has been sent successfully!';
	
	private static $contactForm = "ContactView::ContactForm";
	private static $name = "ContactView::Name";
	private static $email = "ContactView::Email";
	private static $subjectList = "ContactView::SubjectList";
	private static $message = "ContactView::Message";
	private static $antiSpam = "ContactView::AntiSpam";
	private static $send = "ContactView::Send";
	
	private $antiSpamQuestion = "*What is 5+2? (Anti-spam)";
	private $antiSpamAnswer = "7";
	
	private static $successID = "successMessageContainer";
	private static $errorID = "errorMessageContainer";
	

	public function response() {
		
		return 
			$this -> renderTopic() . 
			$this -> generateContactFormHTML() .
			$this -> showFeedbackMessage();
	}
	
	private function showFeedbackMessage() {
		
		if ($this -> feedbackMessage != '') {
			
			if ($this -> feedbackMessage == self::$messageSentSuccessfullyMessage) {
				
				return '
					<div id="'. self::$successID .'">
						<p>'. $this -> feedbackMessage .'</p>
					</div>
				';
				
			} else {
			
				return '
					<div id="'. self::$errorID .'">
						<p>'. $this -> feedbackMessage .'</p>
					</div>
				';	
			}
		}
		
		return '';
	}
	
	private function renderTopic() {
	
		return '<h1>Contact me</h1>';	
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
						<option value="Report bugs/errors">Report bugs/errors</option>
						<option value="Improvement suggestions">Improvement suggestions</option>
						<option value="Other">Other</option>
					</select>
							
					<label>Message</label>
					<textarea name="'. self::$message .'">'. $this -> getRequestMessage() .'</textarea>
					
					<label>'. $this -> antiSpamQuestion .'</label>
					<input name="'. self::$antiSpam .'" type="text">
							
					<input id="submit" name="'. self::$send .'" type="submit" value="Send message">
						
				</form>
			</div>
		';	
	}
	
	public function getEmailContent() {
		
		try {
		
			if ($this -> getRequestName() == '') {
				
				throw new \NameFieldIsEmptyException();
			
			} else if ($this -> getRequestEmail() == '') {
				
				throw new \EmailFieldIsEmptyException();
				
			} else if ($this -> getRequestMessage() == '') {
				
				throw new \MessageFieldIsEmptyException();
				
			} else if ($this -> getRequestAntiSpamAnswer() != $this -> antiSpamAnswer) {
				
				throw new \WrongAntiSpamAnswerException();
			}
			
			// Return email if everything is typed in correctly.
			return new EmailModel(
				$this -> getRequestName(), 
				$this -> getRequestEmail(), 
    			$this -> getRequestSubject(), 
				$this -> getRequestMessage()
			);
			
		} catch (NameFieldIsEmptyException $e) {
			
			$this -> setFeedbackMessage(self::$nameFieldIsEmptyMessage);
			
		} catch (EmailFieldIsEmptyException $e) {
			
			$this -> setFeedbackMessage(self::$emailFieldIsEmptyMessage);
			
		} catch (MessageFieldIsEmptyException $e) {
			
			$this -> setFeedbackMessage(self::$messageFieldIsEmptyMessage);
			
		} catch (WrongAntiSpamAnswerException $e) {
			
			$this -> setFeedbackMessage(self::$wrongAntiSpamAnswerMessage);
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
	
	private function getRequestAntiSpamAnswer() {
		
		if (isset($_POST[self::$antiSpam])) {
			
			return $_POST[self::$antiSpam];
		}
			
		return '';
	}
	
	public function didUserPressSend() {
		
		return isset($_POST[self::$send]);
	}
}