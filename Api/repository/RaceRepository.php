<?php

class RaceRepository {
  private PDO $_connexion;

  public function __construct() {
    $this->_connexion = DataBase::getConnexion();
  }

  public function getInfoFromRace(int $id): Race {
    $stmt = $this->_connexion->prepare('
      SELECT initial_hp, name
        FROM Race
      WHERE id = :id
    ');
    $stmt->execute([
        'id' => $id
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }
  
    $race = new Race();
    $race->setRaceInitialHp($row['initial_hp']);
    $race->setRaceName($row['name']);
    
    return $race;
  }

}
