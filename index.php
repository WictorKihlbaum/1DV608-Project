<?php

// INCLUDE ALL FILES NEEDED.

// Models.

// Views.
require_once('view/LayoutView.php');
require_once('view/NewsfeedView.php');

// Controllers.


// MAKE SURE ERRORS ARE SHOWN.
error_reporting(E_ALL);
ini_set('display_errors', 'On');


// CREATE OBJECTS OF THE VIEWS.
$layoutView = new LayoutView();
$newsfeedView = new NewsfeedView();



// CALL FUNCTIONS.
$layoutView -> render($newsfeedView);