<?php

/* ************************************************
 * Model for the data folder
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
 * Add a new country
 *************************************************/
function addCountry($countrycode, $countryname, $continent, $countrypop, $countrygovt, $countryldr, $countrycap) {
 global $conn;

 // Insert into the country table
 $sql = 'INSERT INTO country (country_code, country_name, continent, country_pop, country_govt, country_leader, country_capital) VALUES (?, ?, ?, ?, ?, ?, ?)';
 // Setup and run the prepared statement
 if ($stmt = $conn->prepare($sql)) {
   if(empty($countrycap)){
     $countrycap = NULL;
   }
  $stmt->bind_param('sssissi', $countrycode, $countryname, $continent, $countrypop, $countrygovt, $countryldr, $countrycap);
  $stmt->execute();
  $result = $conn->affected_rows;
  $stmt->close();
 }
 // Test if the insertion worked
 if ($result) {
return 1;
 } else {
  return 0;
 }
}

/* ************************************************
 * Add a new city
 *************************************************/
function addCity($cityname, $countrycode, $citypop) {
 global $conn;
 
 // Insert into the city table
 $sql = 'INSERT INTO city (city_name, country_code, city_pop) VALUES (?, ?, ?)';
 // Setup and run the prepared statement
 if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param('ssi', $cityname, $countrycode, $citypop);
  $stmt->execute();
  $result = $conn->affected_rows;
  $stmt->close();
 }
 // Test if the insertion worked
 if ($result) {
return 1;
 } else {
  return 0;
 }
}

/* ************************************************
 * Check if country code already exists
 *************************************************/
function countryExists($countrycode) {
 global $conn;
 
 $sql = 'SELECT country_name FROM country WHERE country_code = ?';
 if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param('s', $countrycode);
  $stmt->bind_result($cntryname);
  $stmt->execute();
  $stmt->fetch();
  $stmt->close();
 }
 if (empty($cntryname)) {
  return 0;
 } else {
  return 1;
 }
}

?>