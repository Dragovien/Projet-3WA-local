<?php

// Enable cookies
session_set_cookie_params(["SameSite" => "None"]); 
session_set_cookie_params(["Secure" => "true"]); 
session_set_cookie_params(["HttpOnly" => "true"]); 

session_start();


// Allow CORS
header('Access-Control-Allow-Origin: http://127.0.0.1:5173');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Content-type: text/html; charset=UTF-8');


// solve pre-flight request problem with request method 'Options'
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
header("HTTP/1.1 200 OK");
exit();
}

require 'autoload.php';

require 'router.php';

?>



