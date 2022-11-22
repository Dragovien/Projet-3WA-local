<?php

class Credentials implements \JsonSerializable {
  private string $_login;
  private string $_password;

  public function jsonSerialize(): mixed {
    return get_object_vars($this);
  }

  public function setPassword(string $password):string {
    if (!empty($password)) {
        $this->_password = hash('sha256', $password);
        return '';
    }
    return 'Veuillez rentrer votre mot de passe';
  }
  public function getPassword():string {
    return $this->_login;
  }


  public function setLogin(string $login):string {
    if (!empty($login)) {
        $this->_login = $login;
        return '';
    }
    return 'Veuillez rentrer votre pseudonyme';
  }
  public function getLogin():string {
    return $this->_login;
  }


  public function isValid(string $accountPassword):bool {
    return $this->_password === $accountPassword;
  }
}