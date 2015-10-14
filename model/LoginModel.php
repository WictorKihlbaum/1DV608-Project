<?php

class LoginModel {

    private $sessionModel;
    private $registeredUsersFile;
    
    
    public function __construct($sessionModel, $registeredUsersFile) {
        
        $this -> sessionModel = $sessionModel;
        $this -> registeredUsersFile = $registeredUsersFile;
    }

    public function validateUserInput($user) {
		
		$host = "127.0.0.1";
		$port = 8889;
		$socket = "8889";
		$user = "root";
		$password = "root";
		$dbname = "mylocaldb";
		
		$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
		if ($con) {
			echo "Successful Connection!";
		}
		
		$query = "SELECT userName, password FROM users";

		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> bind_result($userName, $password);
			
			while ($stmt -> fetch()) {
				printf("%s %s\n", $userName, $password);
    		}
				
			$stmt->close();
		}
		
		$con -> close();
		
		
		



		
		
		
		
		
		
		/*while ($stmt->fetch()) {
				
		}*/
		
		
		/*
		$query = "SELECT userName, password FROM users";
		$result = mysqli_query($con, $query) or die("No query");
		
		$users = array();
		
		while ($row = mysqli_fetch_assoc($result)) {
			
			$users[] = $row;
		}
		
		echo $users;
		
		$con -> close();
		*/
		
		


		
		
        /*
        $inputToSearchFor = "Username: " . $user -> getUserName() . " Password: " . $user -> getPassword();
        $textFileToSearchIn = file_get_contents($this -> registeredUsersFile);
        $textFileToSearchIn = explode("\n", $textFileToSearchIn);
        
        if (!in_array($inputToSearchFor, $textFileToSearchIn)) {
        
            throw new \WrongInputException("Wrong name or password");
        }
        
        $this -> sessionModel -> setUserSession();
		*/
    }
    
    public function logoutUser() {
        // Remove user-session when user is being logged out.
        $this -> sessionModel -> unsetUserSession();
    }
    
    public function loggedInUser() {
        // Return session for user.
        return $this -> sessionModel -> getUserSession();
    }
    
}