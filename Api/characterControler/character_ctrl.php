<?php

  $result = decodeJsonFromInput();
  if (!empty($result['error'])) {
    sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, [$result['error']]);
    return;
  }

  $payload = $result['jsonData'];
  if(isset($payload['raceId'])) {
    $payload['raceId'] = intval($payload['raceId']);
  }

  $character = new Character();
  $errors = [
    'name' => $character->setName(htmlentities($payload['name'] ?? '')),
    'sex'  => $character->setSex(htmlentities($payload['sex'] ?? '')),
    'race_id' => $character->setRaceId(htmlentities($payload['raceId'] ?? '')),
  ];

  $errors = array_filter($errors, function($error, $key) {
      return !empty($error);
  }, ARRAY_FILTER_USE_BOTH);

  if (empty($errors)) {
    
    $characterRepo = new CharacterRepository();
    $character = $characterRepo->createCharacter($character);
    
    sendJsonResponse($character, HttpStatusCode::CREATED);
    return;
  }

  sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, $errors);