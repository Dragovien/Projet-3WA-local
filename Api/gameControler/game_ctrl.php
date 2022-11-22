<?php

// Get the character's id from the URL
$characterId = $_GET['id'] ?? '';

if (empty($characterId)) {
  sendJsonResponse(null, HttpStatusCode::BAD_REQUEST, ['Missing id']);
  return;
}


$characterRepo = new CharacterRepository();
$character = $characterRepo->getCharacter($characterId);

sendJsonResponse($character);