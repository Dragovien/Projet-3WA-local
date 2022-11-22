<?php

class Race implements \JsonSerializable {
  private string $raceName;
  private int $raceInitialHp;

  public function jsonSerialize(): mixed {
    return get_object_vars($this);
  }

  public function setRaceName(string $raceName): void {
    $this->raceName = $raceName;
  }
  public function getRaceName():string {
    return $this->raceName;
  }


  public function setRaceInitialHp(int $raceInitialHp): void {
    $this->raceInitialHp = $raceInitialHp;
  }
  public function getRaceInitialHp():int {
    return $this->raceInitialHp;
  }

}