<?php
if($loginflag){
 $logingreetings = '<span class="greeting">Welcome '.$clientfirst.'</span> | ';
 $logingreetings .= '<a href="/clients?action=logout">Logout</a>';
 echo $logingreetings;
} else {
echo '<a href="/clients?action=doregister">Register</a> | <a href="/clients?action=dologin">Login</a>';
}
?> 