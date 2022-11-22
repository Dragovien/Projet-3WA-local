<?php

// function used to decode Json input
function decodeJsonFromInput(): array {
  $result = array();
  $rawData = file_get_contents('php://input');

  if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (empty($rawData)) {
      $result['error'] = 'No data provided';
    } else {
      $result['jsonData'] = json_decode($rawData, true);
      // Check if there is errors on JSON encode
      $jsonError = json_last_error();
      // Crash if an errors occurs
      if ($jsonError !== JSON_ERROR_NONE) {
        $result['error'] = 'Fail to decode JSON : ' . json_last_error_msg();
      }
    }
  }
  return $result;
}

// function used to send Json response
function sendJsonResponse(
  array | object | null $data,
  int $httpStatusCode = HttpStatusCode::OK,
  array $errors = null
): void {

  header("Content-Type: application/json; charset=UTF-8");

  // Encode output data and errors into JSON
  $json = json_encode([
    'data' => $data,
    'errors' => $errors,
  ]);

  // Check if there is errors on JSON encode
  $jsonError = json_last_error();
  // Crash if an errors occurs
  if ($jsonError !== JSON_ERROR_NONE) {
    http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR);
    echo json_encode([
    'errors' => [
      'Fail to encode JSON : ' . json_last_error_msg()
    ]
    ]);
  } else {
      http_response_code($httpStatusCode);
      echo $json;
  }
}
  
// call controlers for the login page
  
$page = isset($_GET['route']) ? $_GET['route'] : '';

if($page === '/createAccount') { // if the user wants to create a new account
  require 'controler/account_ctrl.php'; 
  exit;
} else if($page === '/signIn') { // it the user wants to login
  require 'controler/login_ctrl.php';
  exit;
}

// call controlers in pages reserved to logged admins/users

if(isset($_SESSION['Logged']) && $_SESSION['Logged'] = 'yes') {

  $logged = isset($_GET['route']) ? $_GET['route'] : '';

  switch($logged) {
    case '/listCharacters':
        require 'characterControler/listCharacters_ctrl.php'; // display list of characters belongin to the user
        break;
    case '/character':
        require 'characterControler/character_ctrl.php'; // create a new character
        break;
    case '/adminListAccounts':
        require 'adminControler/listAccounts_ctrl.php'; // display list of all existing accounts 
        break;
    case '/adminControls':
        require 'adminControler/adminAccount_ctrl.php'; // enable the admin to create, delete or modify an account
        break;
    case '/signOut':
        require 'controler/logout_ctrl.php'; // end the current session
        break;
    case '/game':
        require 'gameControler/game_ctrl.php';
        break;
  }
} else {
  sendJsonResponse(null, HttpStatusCode::NOT_FOUND, ["Route $page not found !"]);
}