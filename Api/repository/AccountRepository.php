<?php

class AccountRepository {
  private PDO $_connexion;

  public function __construct() {
    $this->_connexion = DataBase::getConnexion();
  }

  public function getAccount(string $id): ?Account {
    $stmt = $this->_connexion->prepare('
      SELECT id, login, password, firstName, lastName, adminPrivileges
        FROM Account
      WHERE id = :id
    ');
    $stmt->execute([
        'id' => $id
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }
  
    $account = new Account();
    $account->setId($row['id']);
    $account->setLogin($row['login']);
    $account->setFirstName($row['firstName']);
    $account->setLastName($row['lastName']);
    $account->setEncryptedPassword($row['password']);
    $account->setAdminPrivileges($row['adminPrivileges']);

    return $account;
  }

  public function createAccount(Account $account): Account {
    $stmt = $this->_connexion->prepare('
        INSERT INTO Account (id, login, firstName, lastName, password, adminPrivileges) 
        VALUES (UUID(), :login, :firstName, :lastName, :password, :adminPrivileges);
    ');
    $stmt->execute([
        'firstName' => $account->getFirstName(),
        'lastName' => $account->getLastName(),
        'login' => $account->getLogin(),
        'password' => $account->getPassword(),
        'adminPrivileges' => $account->getAdminPrivileges()
    ]);
    $stmt = $this->_connexion->prepare('
        SELECT id
          FROM Account
        WHERE firstName = :firstName AND lastName = :lastName AND login = :login AND adminPrivileges = :adminPrivileges;
    ');
    $stmt->execute([
        'firstName' => $account->getFirstName(),
        'lastName' => $account->getLastName(),
        'login' => $account->getLogin(),
        'adminPrivileges' => $account->getAdminPrivileges()
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $account->setId($row['id']);

    return $account;
  }

  public function updateAccount(Account $account): Account {
    $stmt = $this->_connexion->prepare('
        UPDATE Account
          SET login = :login,
              password = :password,
              firstName = :firstName,
              lastName = :lastName,
              adminPrivileges = :adminPrivileges
        WHERE id = :id
    ');

    $stmt->execute([
      'id' => $account->getId(),
      'login' => $account->getLogin(),
      'password' => $account->getPassword(),
      'firstName' => $account->getFirstName(),
      'lastName' => $account->getLastName(),
      'adminPrivileges' => $account->getAdminPrivileges(),

    ]);

    return $account;
  }

  public function deleteAccount(string $id): void {
    $stmt = $this->_connexion->prepare('
        DELETE FROM Account
        WHERE id = :id
    ');
    $stmt->execute([
        'id' => $id
    ]);
  }

  public function retrieveAccountFromCredentials(Credentials $credentials): ?Account {
    $stmt = $this->_connexion->prepare('
        SELECT *
          FROM Account
        WHERE login = :login
    ');
    $stmt->execute([
        'login' => $credentials->getLogin()
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        return null;
    }

    $account = new Account();
    $account->setLogin($result['login']);
    $account->setEncryptedPassword($result['password']);
    $account->setFirstName($result['firstName']);
    $account->setLastName($result['lastName']);
    $account->setAdminPrivileges($result['adminPrivileges']);
    $account->setId($result['id']);

    return $account;
}

  public function listAccounts(): array {
    $stmt = $this->_connexion->prepare('
      SELECT id, login, firstName, lastName, adminPrivileges
        FROM Account
      ORDER BY adminPrivileges DESC
    ');
    $stmt->execute();

    $accounts = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $account = new Account();
      $account->setId($row['id']);
      $account->setLogin($row['login']);
      $account->setFirstName($row['firstName']);
      $account->setLastName($row['lastName']);
      $account->setAdminPrivileges($row['adminPrivileges']);

      array_push($accounts, $account);
    }

    return $accounts;
  }
}
