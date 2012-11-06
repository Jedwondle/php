<?php

/* ************************************************
 * Model for the clients folder
 *************************************************/

//session_start(); // for troubleshooting
/* ************************************************
 *  Get the database connection object
 *************************************************/
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/conns/conn.php')) {
 require_once $_SERVER['DOCUMENT_ROOT'] . '/conns/conn.php';
} else {
 //$_SESSION['error'] = 'connection won\'t load'; // For troubleshooting
 header('Location: /errordocs/500.php');
 exit;
}

/* ************************************************
 * Register a new client
 *************************************************/
function regClient($firstname, $lastname, $emailaddress, $password) {
 global $conn;

 // Begin the transaction
 $conn->autocommit(FALSE); // Stops db from autosaving info
 $flag = TRUE; // Assumes everything will work
 // Write the first sql, to insert into the parent table
 $sql = 'INSERT INTO client (client_first, client_last) VALUES (?, ?)';
 // Setup and run the prepared statement
 if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param('ss', $firstname, $lastname);
  $stmt->execute();
  $result = $conn->affected_rows;
  $clientid = $conn->insert_id;
  $stmt->close();
 }
 // See if the first insertion worked
 if ($result == FALSE || empty($clientid)) {
  $flag = FALSE;
 }

 // If the flag is still true, do the second insertion to the child table
 if ($flag) {
  $sql = 'INSERT INTO authentication (auth_email, auth_password, client_id) VALUES (?, ?, ?)';

  if ($stmt = $conn->prepare($sql)) {
   $password = crypt($password, '$2a$10$ThisIsABlowfishSaltVlu$');
   $stmt->bind_param('ssi', $emailaddress, $password, $clientid);
   $stmt->execute();
   $result2 = $conn->affected_rows;
   $stmt->close();
  }
  // See if the second insertion worked
  if ($result2 == FALSE) {
   $flag = FALSE;
  }
 }
 // If both insertions worked, save everything and report back
 if ($flag) {
  $conn->commit;
  $conn->autocommit(TRUE);
  return 1;
 } else {
  // If one or both of the insertions failed, rollback and report the failure
  $conn->rollback;
  $conn->autocommit(TRUE);
  return 0;
 }
}

/* ************************************************
 * Check if registrant's email already exists
 *************************************************/
function isUsed($emailaddress) {
 $sql = 'SELECT auth_email FROM authentication WHERE auth_email = ?';
 if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param('s', $emailaddress);
  $stmt->bind_result($returnedemail);
  $stmt->execute();
  $stmt->fetch();
  $stmt->close();
 }
 if (empty($returnedemail)) {
  return 0;
 } else {
  return 1;
 }
}

?>