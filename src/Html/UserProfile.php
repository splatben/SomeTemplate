<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

class UserProfile
{
    use StringEscaper;
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
    * @return string HTML
     * retourne le code html pour l'affichage du User
     */
    public function toHtml(): string
    {
        return <<<HTML
    <p>Nom</p>
        <li>{$this->escapeString($this->user->getLastName())}</li>
    <p>Prenom</p>
        <li>{$this->escapeString($this->user->getFirstName())}</li>
    <p>Login</p>
        <li>{$this->escapeString($this->user->getLogin())}[{$this->user->getId()}]</li>
    <p>Téléphone</p>
        <li>{$this->escapeString($this->user->getPhone())}</li>
    HTML;
    }
}
