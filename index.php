<?php

// INCLUDE ALL FILES NEEDED.

// Models.

// Views.
require_once('view/LayoutView.php');
require_once('view/NewsfeedView.php');

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
$layoutView = new LayoutView();
$newsfeedView = new NewsfeedView();

// CREATE OBJECTS OF CONTROLLERS.
$newsfeedController = new NewsfeedController($newsfeedView, $newsfeedModel);


// CALL FUNCTIONS.
$newsfeedController -> handleRSSFeed();

// RENDER PAGE.
$layoutView -> render($newsfeedView);