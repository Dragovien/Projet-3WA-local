<?php

  $result = decodeJsonFromInput();
  if (!empty($result['error'])) {
    sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, [$result['error']]);
    return;
  }

  // Creation of Account entity
  $payload = $result['jsonData'];
  $account = new Account();
  $errors = [
    'login' => $account->setLogin(htmlentities($payload['login'] ?? '')),
    'password' => $account->setPassword($payload['password'] ?? ''),
    'firstName' => $account->setFirstName(htmlentities($payload['firstName'] ?? '')),
    'lastName' => $account->setLastName(htmlentities($payload['lastName'] ?? '')),
  ];

  $errors = array_filter($errors, function($error, $key) {
      return !empty($error);
  }, ARRAY_FILTER_USE_BOTH);

  if (empty($errors)) {
    $accountRepo = new AccountRepository();
    $account = $accountRepo->createAccount($account);
    sendJsonResponse($account, HttpStatusCode::CREATED);
    return;
  }

  sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, $errors);

