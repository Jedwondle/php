<?php

/*
 * Collection of reusable functions
 */

// Validation functions

function valString($string){
 $string = filter_var($string, FILTER_SANITIZE_STRING);
 return $string;
}

function valNumber($number){
 $number = filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
 $number = filter_var($number, FILTER_VALIDATE_FLOAT);
 return $number;
}

function valEmail($email){
 $email = filter_var($email, FILTER_SANITIZE_EMAIL);
 $email = filter_var($email, FILTER_VALIDATE_EMAIL);
 return $email;
}
?>