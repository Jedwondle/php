<?php
/*
 * Controller for the site root
 */
// Create or access an existing session
session_start();


if($_GET['action']){
 $action = $_GET['action'];
} elseif ($_POST['action']) {
 $action = $_POST['action'];
} 


 include 'home.php';

?>