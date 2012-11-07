<?php
/* ************************************************
 * Controller for the clients directory
 *************************************************/

// Create or access an existing session
session_start();

/* ************************************************
 * Access the model to use the functions stored in it
 *************************************************/
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/clients/model.php')) {
  require_once $_SERVER['DOCUMENT_ROOT'] . '/clients/model.php';
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
 * Request for registration tool
 *************************************************/
if ($action == 'doregister') {
  // Deliver the registration page
  include 'register.php';
  exit;
} 
/* ************************************************
 * Request for login page
 *************************************************/
elseif ($action == 'dologin') {
  // Deliver the login page
  include 'login.php';
  exit;
} 
/* ************************************************
 * Request to register
 *************************************************/
elseif ($action == 'Register') {
  // Handle the registration
 
  // Collect the data
  $firstname = $_POST['cfirst'];
  $lastname = $_POST['clast'];
  $emailaddress = $_POST['cemail'];
  $password = $_POST['cpassword'];
  $password2 = $_POST['cpassword2'];

  // Validate data
  // Step 1 - Clean it up
  $firstname = valString($firstname);
  $lastname = valString($lastname);
  $emailaddress = valEmail($emailaddress);
  $password = valString($password);
  $password2 = valString($password2);
  
  // Step 2 - Check the results of the cleanup
  $errors = array();
  
  // Make sure you have something
  if(empty($firstname) || empty($lastname) || empty($emailaddress) || empty($password) || empty($password2)){
   $errors[0] = 'All fields are required.';
  }
  
  if($password <> $password2){
   $errors[1] = 'Passwords do not match.';
  }
  
  if(isUsed($emailaddress)){
   $errors[2] = 'Email already exists, did you want to login instead?';
  }
  // Step 3 - Notify the user if things are not right
  if(!empty($errors)){
   include 'register.php';
   exit;
  }
  
  
  // Step 4 - Proceed if only if there are no problems
if(empty($errors)){
  $regresult = regClient($firstname, $lastname, $emailaddress, $password);
}

  // Confirm and inform the user
  if ($regresult == 1) {
    $message = "Great news $firstname, you are now registered.";
    include 'login.php';
    exit;
  } else {
    $message = "Sorry $firstname, but there was a problem and the registration did not succeed. Please try again.";
    include 'register.php';
    exit;
  }
} 
/* ************************************************
 * Request to login
 *************************************************/
elseif ($action == 'Login') {
  // Handle the login
  $emailaddress = $_POST['cemail'];
  $password = $_POST['cpassword'];
  $emailaddress = valEmail($emailaddress);
  $password = valString($password);
  
  $loginsuccess = loginClient($emailaddress, $password);
} 
/* ************************************************
 * Default behavior - deliver the register page
 *************************************************/
else {
  include 'register.php';
}
?>