<?php

class RegisterView {
	
	private $registerModel;
	
	private static $loginURL = "login";
    
	private static $registerForm = 'RegisterView::RegisterForm';
    private static $register = 'RegisterView::Register';
    private static $userName = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	
	private $feedbackMessage = "";
	
	private static $noCredentialsMessage = "Username has too few characters, at least 3 characters.<br>Password has too few characters, at least 6 characters.";
	private static $noValidUserNameMessage = "Username has too few characters, at least 3 characters.";
	private static $noValidPasswordMessage = "Password has too few characters, at least 6 characters.";
	private static $passwordsDoNotMatchMessage = "Passwords do not match.";
	private static $invalidCharactersMessage = "Username contains invalid characters.";
	private static $userAlreadyExistsMessage = "User exists, pick another username.";
	private static $registerWhileLoggedInMessage = "You can't register a new user while logged in. Please logout and try again.";
	
	
	public function __construct($registerModel) {
		
		$this -> registerModel = $registerModel;
	}

	public function response() {
		
		$response = $this -> generateRegisterFormHTML();
		
		return 
			$this -> renderTopic() . 
			$response . 
			$this -> renderBackLink();	
	}
	
	private function generateRegisterFormHTML() {
	
		return '
			<div id="registerForm">
				<form method="post" id="'. self::$registerForm .' name="'. self::$registerForm .'"> 
					<fieldset>
						<legend>Register a new user - Write username and password</legend>
						<p id="'. self::$messageId .'">'. $this -> feedbackMessage .'</p>
						
						<label for="'. self::$userName .'">Username :</label>
						<input type="text" id="'. self::$userName .'" name="'. self::$userName .'" /><br>
						
						<label for="'. self::$password .'">Password :</label>
						<input type="password" id="'. self::$password .'" name="'. self::$password .'" /><br>
						
						<label for="'. self::$passwordRepeat .'">Repeat password :</label>
						<input type="password" id="'. self::$passwordRepeat .'" name="'. self::$passwordRepeat .'" /><br>
						
						<input type="submit" name="'. self::$register .'" value="Register" />
					</fieldset>
				</form>
			</div>
		';
	}
	
	private function renderTopic() {
	
		return '<h1>Register new user</h1>';
	}
	
	private function renderBackLink() {
	
		return '<a href="?'. self::$loginURL .'">Back to login</a>';	
	}
	
	public function didUserPressRegister() {
		
		return isset($_POST[self::$register]);
	}
	
	private function getRequestUserName() {
	
		if (isset($_POST[self::$userName])) {
			
			return $_POST[self::$userName];
		}
		
		return "";
	}
	
	private function getRequestPassword() {
	
		if (isset($_POST[self::$password])) {
			
			return $_POST[self::$password];
		}
			
		return "";
	}
	
	private function getRequestPasswordRepeat() {
		
		if (isset($_POST[self::$passwordRepeat])) {
			
			return $_POST[self::$passwordRepeat];
		} 
	
		return "";
	}
	
	public function getNewUser() {
		
		try {
			
			if ($this -> getRequestUserName() == "" && // Empty fields.
				$this -> getRequestPassword() == "" &&
				$this -> getRequestPasswordRepeat() == "") {
				
				throw new \NoCredentialsException();
				
			} else if ($this -> getRequestUserName() == "" || // Empty, to short or invalid username.
				strlen($this -> getRequestUserName()) < 3) {

				throw new \NoValidUserNameException();
			
			} else if ($this -> getRequestPassword() == "" || // Empty, to short or invalid password.
				strlen($this -> getRequestPassword()) < 6) {

				throw new \NoValidPasswordException();
				
			} else if ($this -> getRequestPassword() != $this -> getRequestPasswordRepeat()) { // No matching passwords.
				
				throw new \PasswordsDoNotMatchException();
				
			} else if (!ctype_alnum($this -> getRequestUserName()) && // Invalid username characters.
				$this -> getRequestUserName() != "") {
				
				throw new \InvalidCharactersException();
			}
			// Return new user if everything is typed in correctly.
			return new UserModel($this -> getRequestUserName(), $this -> getRequestPassword());		
		
		} catch (NoCredentialsException $e) {
		
			$this -> setFeedbackMessage(self::$noCredentialsMessage);
			
		} catch (NoValidUserNameException $e) {
			
			$this -> setFeedbackMessage(self::$noValidUserNameMessage);
			
		} catch (NoValidPasswordException $e) {
			
			$this -> setFeedbackMessage(self::$noValidPasswordMessage);
			
		} catch (PasswordsDoNotMatchException $e) {
			
			$this -> setFeedbackMessage(self::$passwordsDoNotMatchMessage);
			
		} catch (InvalidCharactersException $e) {
			
			$this -> setFeedbackMessage(self::$invalidCharactersMessage);
		} 
	}
	
	private function setFeedbackMessage($feedbackMessage) {
		
		$this -> feedbackMessage = $feedbackMessage;
	}
	
	public function setUserAlreadyExistsFeedbackMessage() {
		
		$this -> setFeedbackMessage(self::$userAlreadyExistsMessage);
	}
	
	public function setRegisterWhileLoggedInFeedbackMessage() {
		
		$this -> setFeedbackMessage(self::$registerWhileLoggedInMessage);
	}
	
}