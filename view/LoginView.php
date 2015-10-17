<?php

class LoginView {
	
	private $loginModel;
	private $sessionModel;
	
	private static $registerLink = 'LoginView::RegisterLink';
	private static $registerURL = 'register';
	
	private static $loginForm = 'LoginView::LoginForm';
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $messageId = 'LoginView::Message';

	private $feedbackMessage = "";
	
	private static $loginMessage = "Welcome";
	private static $logoutMessage = "Bye bye!";
	private static $missingUserNameMessage = "Username is missing";
	private static $missingPasswordMessage = "Password is missing";
	private static $wrongInputMessage = "Wrong name or password";
	private static $registeredNewUserMessage = "Registered new user.";
	
	
	public function __construct($loginModel, $sessionModel) {
		
		$this -> loginModel = $loginModel;
		$this -> sessionModel = $sessionModel;
	}

	public function response() {
		
		if ($this -> loginModel -> loggedInUser()) { 
			
			$response = $this -> generateLogoutButtonHTML();
			
		} else {
			
			$response = $this -> generateLoginFormHTML();			
		}

		return $this -> renderTopic() . $response . $this -> renderRegisterLink();	
	}
	
	private function renderTopic() {
	
		if ($this -> loginModel -> loggedInUser()) {
			
			return '<h1>You are now logged in</h1>';
			
		} else {
			
			return '<h1>You are not logged in</h1>';
		}
	}
	
	private function generateLoginFormHTML() {
	
		return '
			<div id="loginForm">
				<form method="post" id="'. self::$loginForm .'" name="'. self::$loginForm .'"> 
					<fieldset>
						<legend>Login - enter Username and password</legend>
						<p id="'. self::$messageId .'">' . $this -> feedbackMessage . '</p>
						
						<label for="' . self::$name . '">Username:</label>
						<input type="text" id="'. self::$name .'" name="'. self::$name .'" /><br />
	
						<label for="' . self::$password . '">Password:</label>
						<input type="password" id="'. self::$password .'" name="'. self::$password .'" /><br />
						
						<input type="submit" id="'. self::$login .'" name="'. self::$login .'" value="Login" />
					</fieldset>
				</form>
			</div>
		';
	}
	
	private function renderRegisterLink() {
	
		return '
			<p><a href="?' . self::$registerURL . '" name="' . self::$registerLink . ' id="'. self::$registerLink .'"">Not a registered user? Click here to create a new account!</a></p>
		';	
	}
	
	private function generateLogoutButtonHTML() {
		
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this -> feedbackMessage .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	public function didUserPressLogin() {

		return isset($_POST[self::$login]);
	}
	
	public function didUserPressLogout() {
		
		return isset($_POST[self::$logout]);
	}
	
	public function getUser() {
		
		try { // If one or the other of the two input fields are empty throw an exception describing what's wrong.
			
			if ($this -> getRequestUserName() == "") {

				throw new \NoValidUserNameException();
			
			} else if ($this -> getRequestPassword() == "") {

				throw new \NoValidPasswordException();
			}
			// Return user if everything is typed in correctly.
			return new UserModel($this -> getRequestUserName(), $this -> getRequestPassword());		
		
		} catch (NoValidUserNameException $e) {
			
			$this -> setFeedbackMessage(self::$missingUserNameMessage);
			
		} catch (NoValidPasswordException $e) {
			
			$this -> setFeedbackMessage(self::$missingPasswordMessage);	
		}
	}
	
	private function getRequestUserName() {
		
		if (isset($_POST[self::$name])) {
			
			return $_POST[self::$name];
		}
			
		return "";
	}

	private function getRequestPassword() {
		
		if (isset($_POST[self::$name])) {
			
			return $_POST[self::$password];
		}
			
		return "";
	}
	
	private function setFeedbackMessage($feedbackMessage) {
		
		$this -> feedbackMessage = $feedbackMessage;
	}
	
	public function setLoginFeedbackMessage() {
		
		$this -> setFeedbackMessage(self::$loginMessage);
	}
	
	public function setLogoutFeedbackMessage() {
		
		$this -> setFeedbackMessage(self::$logoutMessage);
	}
	
	public function setWrongInputFeedbackMessage() {
		
		$this -> setFeedbackMessage(self::$wrongInputMessage);
	}
	
	public function setRegisteredNewUserFeedbackMessage() {
		
		$this -> setFeedbackMessage(self::$registeredNewUserMessage);
	}
	
}