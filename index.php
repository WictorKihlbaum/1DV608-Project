<?php

// MAKE SURE ERRORS ARE SHOWN.
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// SET DEFAULT TIME ZONE.
date_default_timezone_set('Europe/Stockholm');

// INCLUDE ALL FILES NEEDED.

// TODO: Find out a more effective way to require the files.

// MODELS.
require_once('model/SessionModel.php');
require_once('model/NewsfeedModel.php');
require_once('model/LoginModel.php');
require_once('model/RegisterModel.php');
require_once('model/UserModel.php');
//DAL.
require_once('model/DAL/UserDAL.php');

// VIEWS.
require_once('view/HomeView.php');
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/NewsfeedView.php');
require_once('view/AboutView.php');
require_once('view/LayoutView.php');

// CONTROLLERS.
require_once('controller/MasterController.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/NewsfeedController.php');

// EXTENDED CUSTOM EXCEPTIONS.
require_once('Exceptions/InvalidCharactersException.php');
require_once('Exceptions/NoCredentialsException.php');
require_once('Exceptions/NoValidPasswordException.php');
require_once('Exceptions/NoValidUserNameException.php');
require_once('Exceptions/PasswordsDoNotMatchException.php');
require_once('Exceptions/RegisterWhileLoggedInException.php');
require_once('Exceptions/UserAlreadyExistsException.php');
require_once('Exceptions/WrongInputException.php');


// CREATE OBJECTS OF THE MODELS.
$userDAL = new UserDAL();
$sessionModel = new SessionModel();
$loginModel = new LoginModel($sessionModel, $userDAL);
$registerModel = new RegisterModel($sessionModel, $userDAL);
$newsfeedModel = new NewsfeedModel();

// CREATE OBJECTS OF THE VIEWS.
$homeView = new HomeView();
$loginView = new LoginView($loginModel, $sessionModel);
$registerView = new RegisterView($registerModel);
$newsfeedView = new NewsfeedView($sessionModel);
$aboutView = new AboutView();
$layoutView = new LayoutView($homeView, $loginView, $registerView, $newsfeedView, $aboutView);

// CREATE OBJECTS OF CONTROLLERS.
$loginController = new LoginController($loginView, $loginModel, $sessionModel);
$registerController = new RegisterController($registerView, $registerModel);
$newsfeedController = new NewsfeedController($newsfeedView, $newsfeedModel, $sessionModel);
$masterController = new MasterController($loginController, $registerController, $newsfeedController);


// CALL FUNCTIONS.
$masterController -> handleUserRequest();
$layoutView -> renderLayout();
