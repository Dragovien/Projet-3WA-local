<?php
$characterRepo = new CharacterRepository();
$characters = $characterRepo->listCharacters();

sendJsonResponse($characters);
