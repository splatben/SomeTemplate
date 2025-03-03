<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthentificationException;
use Entity\Exception\EntityNotFoundException;
use Entity\User;
use Html\StringEscaper;
use Service\Exception\SessionException;
use Service\Session;

class UserAuthentication
{
    use StringEscaper;
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';
    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';
    private const LOGOUT_INPUT_NAME = 'logout';
    private ?User $user = null;

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login_input_name = self::LOGIN_INPUT_NAME;
        $password_input_name = self::PASSWORD_INPUT_NAME;

        return <<<HTML
    <form action="$action" method="post">
    <input type="text" name="$login_input_name" value="" placeholder="$login_input_name" />
    <input type="password" name="$password_input_name" value="" placeholder="$password_input_name" />
    <input type = "submit" value="$submitText">
    </form>
    HTML;
    }

    /**
     * Authenticate User
     * @throws SessionException
     * @throws AuthentificationException
     */
    public function getUserFromAuth(): User
    {
        try {
            $user = User::findByCredentials($_POST[self::LOGIN_INPUT_NAME], $_POST[self::PASSWORD_INPUT_NAME]);
            $this->SetUser($user);

            return $user;
        } catch (EntityNotFoundException) {
            throw new AuthentificationException('User not found');
        }
    }

    /**
     * @param User $user stocke l'utilisateur dans la session
     * @throws SessionException
     */
    protected function SetUser(User $user): void
    {
        Session::start();
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] = $user;
        $this->user = $user;
    }

    /**
     * Regarde si l'utilisateur est connecté
     * @throws SessionException
     * @return bool
     */
    public function isUserConnected(): bool
    {
        Session::start();
        $res = false;
        if (isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY])) {
            $res = null !== $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY];
        }

        return $res;
    }

    /**
     * Logout
     * @throws SessionException
     */
    public function logoutIfRequested(): void
    {
        Session::start();
        if (isset($_POST[self::LOGOUT_INPUT_NAME])) {
            if (isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY])) {
                unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
            }
        }
    }
    /**
     * @param $act string action formulaire
     * @param $txt string text bouton submit
     * @return string formulaire HTML
     * */
    public function logoutForm(string $act, string $txt = 'Oui'): string
    {
        $LOGOUT_INPUT_NAME = self::LOGOUT_INPUT_NAME;

        return <<<HTML
        <form action="$act" method="post">
        Voulez-vous vous déconnecter ?
        <input type ="hidden" value="1" name="$LOGOUT_INPUT_NAME" />
        <submit>$txt</submit>
        HTML;
    }
}
