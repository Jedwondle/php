<?php
/* ************************************************
 * Controller for the data directory
 *************************************************/

// Create or access an existing session
session_start();

/* ************************************************
 * Access the model to use the functions stored in it
 *************************************************/
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/content/model.php')) {
  require_once $_SERVER['DOCUMENT_ROOT'] . '/content/model.php';
} else {
  //$_SESSION['error'] = 'model won\'t load'; // For troubleshooting
  header('Location: /errordocs/500.php');
  exit;
}

/* ************************************************
 * Access the library functions
 *************************************************/
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/library/library.php')) {
  require_once $_SERVER['DOCUMENT_ROOT'] . '/library/library.php';
} else {
  //$_SESSION['error'] = 'model won\'t load'; // For troubleshooting
  header('Location: /errordocs/500.php');
  exit;
}

/* ************************************************
 * Capture the action key/value
 *************************************************/
if ($_GET['action']) {
  $action = $_GET['action'];
} elseif ($_POST['action']) {
  $action = $_POST['action'];
}

/* ************************************************
 * Sanitize the action value from the browser
 *************************************************/
$action = valString($action);

/* ************************************************
 * Request for new country tool
 *************************************************/
if ($action == 'newcountry') {
  // Deliver the add new country page
  include 'newcountry.php';
  exit;
} 
/* ************************************************
 * Request for new city tool
 *************************************************/
elseif ($action == 'newcity') {
  // Deliver the add new city page
  include 'newcity.php';
  exit;
} 
/* ************************************************
 * Add a New Country
 *************************************************/
elseif ($action == 'Add Country') { 
  // Collect the data
  $countryname = $_POST['cname'];
  $countrycode = $_POST['ccode'];
  $continent = $_POST['continent'];
  $countrypop = $_POST['cpop'];
  $countrygovt = $_POST['cgovt'];
  $countryleader = $_POST['cleader'];
  $countrycapital = $_POST['ccapital'];

  // Validate data
  // Step 1 - Clean it up
  $countryname = valString($countryname);
  $countrycode = valString($countrycode);
  $continent = valString($continent);
  $countrypop = valNumber($countrypop);
  $countrygovt = valString($countrygovt);
  $countryleader = valString($countryleader);
  $countrycapital = valString($countrycapital);
  
  // Step 2 - Check the results of the cleanup
  $errors = array();
  
  // Make sure you have something
  if(empty($countryname) || empty($countrycode) || empty($continent) || empty($countrypop) || empty($countrygovt) || empty($countryleader)){
   $errors[0] = 'All fields, except capital city, are required.';
  }
  
  if(countryExists($countrycode)){
   $errors[1] = 'The country code already exists, please select a new code.';
  }

  // Step 3 - Notify the user if things are not right
  if(!empty($errors)){
   include 'newcountry.php';
   exit;
  }
  
  // Step 4 - Proceed if only if there are no problems
if(empty($errors)){
  $addresult = addCountry($countrycode, $countryname, $continent, $countrypop, $countrygovt, $countryleader, $countrycapital);
}

  // Confirm and inform the user
  if ($addresult == 1) {
    $message = '<b>'.$countryname.'</b> was added successfully.';
    $_SESSION['message'] = $message;
    header('Location: /clients/admin.php');
    exit;
  } else {
    $message =  'Sorry, the insertion of <b>'.$countryname.'</b> failed.';
    $_SESSION['message'] = $message;
    header('Location: /clients/admin.php');
    exit;
  }
} 
/* ************************************************
 * Add a New City
 *************************************************/
elseif ($action == 'Add City') {
  $cityname = $_POST['ctyname'];
  $countrycode = $_POST['ccode'];
  $citypop = $_POST['ctypop'];
  
  $cityname = valString($cityname);
  $countrycode = valString($countrycode);
  $citypop = valNumber($citypop);
  
  $errors = array();
  
  if(empty($cityname) || empty($countrycode) || empty($citypop)){
   $errors[0] = 'All fields are required.';
  }
  
  $okcountry = countryExists($countrycode);
  if(!$okcountry){
   $errors[1] = 'The country code entered is not valid';
  }
  
  if(!empty($errors)){
   include 'newcity.php';
   exit;
  }
  
  if(empty($errors)){
   $addresult = addCity($cityname, $countrycode, $citypop);
  }
  
  // Confirm and inform the user
  if ($addresult == 1) {
    $message = 'The city of <b>'.$cityname.'</b> was added successfully.';
    $_SESSION['message'] = $message;
    header('Location: /clients/admin.php');
    exit;
  } else {
    $message =  'Sorry, the insertion of <b>'.$cityname.'</b> failed.';
    $_SESSION['message'] = $message;
    header('Location: /clients/admin.php');
    exit;
  }
} 
/* ************************************************
 * Default behavior - Go to Login Page
 *************************************************/
else {
header('Location: /clients?action=dologin');
exit;
}
?>