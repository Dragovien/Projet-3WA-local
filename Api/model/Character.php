<?php

class Character implements \JsonSerializable {
  private string $id;
  private string $name;
  private string $sex;
  private Race $race;
  private int $raceId;
  private int $currentHp;
  private int $currentMaxHp;
  private string $accountId;

  public function jsonSerialize(): mixed {
    return get_object_vars($this);
  }

  public function __construct() {
    $this->accountId = $_SESSION['accountId'];
  }
  
  
  public function setId($id): string {
    if (isset($this->id)) {
      return 'Un id est déjà spécifié';
    }
    $this->id = $id;
    return '';
  }
  public function getId():string {
    return $this->id;
  }
  
  public function setRace(Race $race): void {
    $this->race = $race;
  }
  public function getRace():Race {
    return $this->race;
  }
  
  
  public function setName(string $name): string {
    if (!empty($name)) {
      $this->name = $name;
      return '';
    }
    return 'Veuillez définir le nom de votre personnage';
  }
  public function getName():string {
    return $this->name;
  }


  public function setSex(string $sex): string {
    if (!empty($sex)) {
        $this->sex = $sex;
        return '';
    }
    return 'Veuillez choisir le sexe de votre personnage';
  }
  public function getSex():string {
    return $this->sex;
  }


  public function setRaceId($raceId): string {
    if (!empty($raceId)) {
        $this->raceId = $raceId;
        return '';
    }
    return 'Veuillez choisir la race de votre personnage';
  }
  public function getRaceId():int {
    return $this->raceId;
  }


  public function setCurrentHp(int $currentHp): void {
    $this->currentHp = $currentHp;
  }
  public function getCurrentHp():int {
    return $this->currentHp;
  }
  
  
  public function setCurrentMaxHp(int $currentMaxHp): void {
    $this->currentMaxHp = $currentMaxHp;
  }
  public function getCurrentMaxHp():int {
    return $this->currentMaxHp;
  }
  
  
  public function setAccountId(string $accountId): void {
    $this->accountId = $accountId;
  }
  public function getAccountId():string {
    return $this->accountId;
  }
}

