<?php

// INCLUDE ALL FILES NEEDED.

// Models.

// Views.
require_once('view/HomeView.php');
require_once('view/RegistrationView.php');
require_once('view/NewsfeedView.php');
require_once('view/AboutView.php');

require_once('view/LayoutView.php');
require_once('view/LoginView.php');

// Controllers.
require_once('controller/NewsfeedController.php');

// Models.
require_once('model/NewsfeedModel.php');


// MAKE SURE ERRORS ARE SHOWN.
error_reporting(E_ALL);
ini_set('display_errors', 'On');


// CREATE OBJECTS OF THE MODELS.
$newsfeedModel = new NewsfeedModel();

// CREATE OBJECTS OF THE VIEWS.
$homeView = new HomeView();
$registrationView = new RegistrationView();
$newsfeedView = new NewsfeedView();
$aboutView = new AboutView();
$navigationView = new NavigationView();
$layoutView = new LayoutView($homeView, $registrationView, $newsfeedView, $aboutView);


// CREATE OBJECTS OF CONTROLLERS.
$newsfeedController = new NewsfeedController($newsfeedView, $newsfeedModel);


// CALL FUNCTIONS.
//$newsfeedController -> handleRSSFeed();

// RENDER PAGE.
$layoutView -> renderLayout();