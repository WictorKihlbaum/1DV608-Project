<?php

// MAKE SURE ERRORS ARE SHOWN.
// (TURNED OFF FOR PUBLIC SERVER)
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

// SET DEFAULT TIME ZONE.
date_default_timezone_set('Europe/Stockholm');

// INCLUDE ALL FILES NEEDED.

// MODELS.
require_once('model/SessionModel.php');
require_once('model/NewsfeedModel.php');
require_once('model/HomeModel.php');
require_once('model/LoginModel.php');
require_once('model/RegisterModel.php');
require_once('model/UserModel.php');
require_once('model/EmailModel.php');
require_once('model/RssModel.php');
require_once('model/ItemModel.php');
require_once('model/SiteModel.php');
require_once('model/ServiceModel.php');
require_once('model/ContactModel.php');

//DAL.
require_once('model/DAL/UserDAL.php');
require_once('model/DAL/RssDAL.php');

// VIEWS.
require_once('view/HomeView.php');
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/NewsfeedView.php');
require_once('view/ContactView.php');
require_once('view/LayoutView.php');
require_once('view/NavigationView.php');

// CONTROLLERS.
require_once('controller/MasterController.php');
require_once('controller/HomeController.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/NewsfeedController.php');
require_once('controller/ContactController.php');

// EXTENDED CUSTOM EXCEPTIONS.

// LOGIN/REGISTER EXCEPTIONS.
require_once('Exceptions/InvalidCharactersException.php');
require_once('Exceptions/NoCredentialsException.php');
require_once('Exceptions/NoValidPasswordException.php');
require_once('Exceptions/NoValidUserNameException.php');
require_once('Exceptions/PasswordsDoNotMatchException.php');
require_once('Exceptions/RegisterWhileLoggedInException.php');
require_once('Exceptions/UserAlreadyExistsException.php');
require_once('Exceptions/WrongInputException.php');
// CONTACT EXCEPTIONS.
require_once('Exceptions/NameFieldIsEmptyException.php');
require_once('Exceptions/EmailFieldIsEmptyException.php');
require_once('Exceptions/MessageFieldIsEmptyException.php');
require_once('Exceptions/WrongAntiSpamAnswerException.php');
require_once('Exceptions/EmailNotSentException.php');


// CREATE OBJECTS OF THE MODELS.
$userDAL = new UserDAL();
$rssDAL = new RssDAL();
$serviceModel = new ServiceModel($userDAL, $rssDAL);
$sessionModel = new SessionModel();
$homeModel = new HomeModel($serviceModel);
$loginModel = new LoginModel($sessionModel, $serviceModel);
$registerModel = new RegisterModel($sessionModel, $serviceModel);
$newsfeedModel = new NewsfeedModel($serviceModel);
$contactModel = new ContactModel();

// CREATE OBJECTS OF THE VIEWS.
$navigationView = new NavigationView();
$homeView = new HomeView($sessionModel);
$loginView = new LoginView($loginModel, $sessionModel);
$registerView = new RegisterView($registerModel);
$newsfeedView = new NewsfeedView($sessionModel);
$contactView = new ContactView();
$layoutView = new LayoutView($homeView, $loginView, $registerView, $newsfeedView, $contactView);

// CREATE OBJECTS OF CONTROLLERS.
$homeController = new HomeController($homeView, $homeModel, $sessionModel);
$loginController = new LoginController($loginView, $loginModel, $sessionModel);
$registerController = new RegisterController($registerView, $registerModel, $navigationView);
$newsfeedController = new NewsfeedController($newsfeedView, $newsfeedModel, $sessionModel);
$contactController = new ContactController($contactView, $contactModel);
$masterController = new MasterController($homeController, $loginController, $registerController, $newsfeedController, $contactController);

// CALL FUNCTIONS.
$masterController -> handleUserRequest();
$layoutView -> renderLayout();