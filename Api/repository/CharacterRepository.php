<?php

class CharacterRepository {
  private PDO $_connexion;
  private RaceRepository $_raceRepo;

  public function __construct() {
    $this->_connexion = DataBase::getConnexion();
    $this->_raceRepo = new RaceRepository();
  }

  public function createCharacter(Character $character): Character {
    $characterRace = $this->_raceRepo->getInfoFromRace($character->getRaceId());

    $stmt = $this->_connexion->prepare('
        INSERT INTO `Character` (id, name, sex, race_id, current_hp, current_max_hp, account_id) 
        VALUES (UUID(), :name, :sex, :race_id, :current_hp, :current_max_hp, :account_id);
    ');
    $stmt->execute([
        'name' => $character->getName(),
        'sex' => $character->getSex(),
        'race_id' => $character->getRaceId(),
        'current_hp' => $characterRace->getRaceInitialHp(),
        'current_max_hp' => $characterRace->getRaceInitialHp(),
        'account_id' => $character->getAccountId()
    ]);
    $stmt = $this->_connexion->prepare('
        SELECT id
          FROM `Character`
        WHERE name = :name AND 
              sex = :sex AND 
              race_id = :race_id AND
              current_hp = :current_hp AND 
              current_max_hp = :current_max_hp AND 
              account_id = :account_id;
    ');
    $stmt->execute([
        'name' => $character->getName(),
        'sex' => $character->getSex(),
        'race_id' => $character->getRaceId(),
        'current_hp' => $characterRace->getRaceInitialHp(),
        'current_max_hp' => $characterRace->getRaceInitialHp(),
        'account_id' => $character->getAccountId()
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $character->setId($row['id']);

    return $character;
  }
  
  public function listCharacters(): array {
    $stmt = $this->_connexion->prepare('
      SELECT `Character`.id,
             `Character`.name as charName, 
             `Character`.sex,
             `Character`.race_id, 
             Race.name, 
             Race.initial_hp, 
             `Character`.current_hp,
             `Character`.current_max_hp,
             `Character`.account_id
        FROM `Character`
      INNER JOIN Race ON Race.id = `Character`.race_id
      WHERE `Character`.account_id = :account_id'
    );
    
    $stmt->execute([
      'account_id' => $_SESSION['accountId'],
    ]);

    $characters = [];
    $characterRaces = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $character = new Character();

      $character->setId($row['id']);
      $character->setName($row['charName']);
      $character->setSex($row['sex']);
      $character->setRaceId($row['race_id']);
      $character->setCurrentHp($row['current_hp']);
      $character->setCurrentMaxHp($row['current_max_hp']);
      $character->setAccountId($row['account_id']);

      $characterRace = new Race();
      $characterRace->setRaceName($row['name']);
      $characterRace->setRaceInitialHp($row['initial_hp']);

      $character->setRace($characterRace);

      array_push($characters, $character);
    }
    return $characters;
  }

  public function getCharacter(string $id): Character {
    $stmt = $this->_connexion->prepare('
      SELECT `Character`.id, 
      `Character`.name as charName, 
      `Character`.sex, 
      Race.name, 
      Race.initial_hp, 
      `Character`.current_hp,
      `Character`.current_max_hp
        FROM `Character`
        INNER JOIN Race ON Race.id = `Character`.race_id
      WHERE `Character`.id = :id
    ');
    $stmt->execute([
        'id' => $id
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }
    $characters = [];

    $character = new Character();
    $character->setId($row['id']);
    $character->setName($row['charName']);
    $character->setSex($row['sex']);
    $character->setCurrentHp($row['current_hp']);
    $character->setCurrentMaxHp($row['current_max_hp']);

    $characterRace = new Race();
    $characterRace->setRaceName($row['name']);
    $characterRace->setRaceInitialHp($row['initial_hp']);

    $character->setRace($characterRace);

    array_push($characters, $character);

    return $character;
  }
}
