<?php

class Room implements \JsonSerializable {
    private string $id;
    private string $visited;

    private string $characterId;

    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }

    public function setId($id): string {
        if (isset($this->id)) {
          return 'Un id est déjà spécifié';
        }
        $this->id = $id;
        return '';
    }

    public function setVisited(string $visited): string {
            $this->visited = $visited;
    }


    public function setCharacterId($characterId): string {
        if (isset($this->characterId)) {
          return 'Un id est déjà spécifié';
        }
        $this->characterId = $characterId;
        return '';
    }

    public function getId():string {
        return $this->id;
    }

    public function getVisited():string {
        return $this->visited;
    }

    public function getCharacterId():string {
        return $this->characterId;
    }

}