<?php

function proceedCreateAccount(): void {
  $result = decodeJsonFromInput();
  if (!empty($result['error'])) {
    sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, [$result['error']]);
    return;
  }

  // Création de l'entité Account + assign adminPrivileges
  $payload = $result['jsonData'];
  $account = new Account();
  $errors = [
    'login'     => $account->setLogin(htmlentities($payload['login'] ?? '')),
    'password'  => $account->setPassword($payload['password'] ?? ''),
    'firstName' => $account->setFirstName(htmlentities($payload['firstName'] ?? '')),
    'lastName'  => $account->setLastName(htmlentities($payload['lastName'] ?? '')),
    'adminPrivileges'  => $account->setAdminPrivileges(htmlentities($payload['adminPrivileges'] ?? '')),
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
}

function proceedUpdateAccount(): void {
  // Get id from url of the account that needs to be modified 
  $accountId = $_GET['id'] ?? '';
  if (empty($accountId)) {
    sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, ['Missing id']);
    return;
  }

  $accountRepo = new AccountRepository();
  $account = $accountRepo->getAccount($accountId);
  if (empty($account)) {
    sendJsonResponse(null, HttpStatusCode::NOT_FOUND, ['Account not found']);
    return;
  }

  $result = decodeJsonFromInput();
  if (!empty($result['error'])) {
    sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, [$result['error']]);
    return;
  }

  $payload = $result['jsonData'];
  $errors = [
    'login'     => $account->setLogin($payload['login'] ?? ''),
    'firstName' => $account->setFirstName($payload['firstName'] ?? ''),
    'lastName'  => $account->setLastName($payload['lastName'] ?? ''),
    'adminPrivileges'  => $account->setAdminPrivileges($payload['adminPrivileges'] ?? ''),
  ];
  if (!empty($payload['password'])) {
    $errors = array_merge($errors, [
      'password'  => $account->setPassword($payload['password']),
    ]);
  }

  $errors = array_filter($errors, function($error, $key) {
      return !empty($error);
  }, ARRAY_FILTER_USE_BOTH);

  if (empty($errors)) {
    $account = $accountRepo->updateAccount($account);
    sendJsonResponse($account, HttpStatusCode::OK);
    return;
  }

  // S'il y a des erreurs dans les données fournies par le client
  // On les retourne une réponse de type BAD_REQUEST sans mettre à jour l'Account dans la BDD
  sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, $errors);
}

function proceedDeleteAccount(): void {

  $accountId = $_GET['id'] ?? '';
  if (empty($accountId)) {
    sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, ['Missing id']);
    return;
  }

  $accountRepo = new AccountRepository();
  $accountRepo->deleteAccount($accountId);

  sendJsonResponse(null, HttpStatusCode::NO_CONTENT);
}

switch($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    proceedCreateAccount();
    break;
  case 'PUT':
    proceedUpdateAccount();
    break;
  case 'DELETE':
    proceedDeleteAccount();
    break;
}