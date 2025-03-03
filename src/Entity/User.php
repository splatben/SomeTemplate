<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $login;
    private string $phone;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Requete sur la base de donnée pour connecter l'utilisateur
     * @param string $password
     * @param string $login
     * @return User
     * @throws EntityNotFoundException
     */
    public static function findByCredentials(string $login,string  $password): User
    {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
        SELECT id, lastName, firstName, login, phone 
        FROM users 
        WHERE login = :login and sha512pass = SHA2(:password,512);
        SQL);
        $stmt->execute([':login' => $login, ':password' => $password]);
        $row = $stmt->fetchObject(User::class);
        if (!$row) {
            throw new EntityNotFoundException();
        }
        return $row;
    }
}
