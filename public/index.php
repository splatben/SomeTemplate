<?php

declare(strict_types=1);

use Html\AppWebPage;

$webPage = new AppWebPage('Gestion des données de session - authentification');

$webPage->appendContent(
    <<<HTML
    <h2>Bonjours</h2>
    <h3>Ce template contient les class pour gerer l'authentification d'un utilisateur en phpLegacy </h3>
HTML
);

echo $webPage->toHTML();
