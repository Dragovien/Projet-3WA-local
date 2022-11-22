<?php   

// Get data sent by the user
  $result = decodeJsonFromInput();
  if (!empty($result['error'])) {
// Return bad request http stattus if empty or wrong data
    sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, [$result['error']]);
    return;
  }

  $payload = $result['jsonData'];
  $credentials = new Credentials();
  $errors = [
    'login'     => $credentials->setLogin($payload['login'] ?? ''),
    'password'  => $credentials->setPassword($payload['password'] ?? ''),
  ];

// Remove empty errors from the errors array
  $errors = array_filter($errors, function($error, $key) {
    return !empty($error);
  }, ARRAY_FILTER_USE_BOTH);

  if (empty($errors)) {

    $accountRepo = new AccountRepository();

    $account = $accountRepo->retrieveAccountFromCredentials($credentials);
    
    if ($account) {
      if ($credentials->isValid($account->getPassword())) {

          $_SESSION['Logged'] = 'yes';
          $_SESSION['accountId'] = $account->getId();

          sendJsonResponse($account, HttpStatusCode::OK);
          return;
      }
    }
  }

  // return bad request http status if errors in data
  sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, $errors);