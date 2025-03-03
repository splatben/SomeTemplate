# Template projet phpLegacy
#### Par Benoit Collot

### Windows

Sur Windows, il faut retirer le point dans les fichiers qui commence par un point comme **.php-cs-fixer.php** pour laisser
**php-cs-fixer.php**

## Serveur local

On utilisera la commande ```Composer "start:linux"``` pour lancer le serveur local 
sur Linux et ```Composer:windows``` pour lancer sur Windows
puis rendez-vous a l'adresse : http://localhost:8000/ Pour accéder à la première page

## Style de codage

Php fixer permet de tester votre code afin de voir s'il correspond à la norme indiquée ici Psr-4.
Pour utiliser php cs fixer différente commande :  
```php vendor/bin/php-cs-fixer fix --dry-run``` --dry-run pour test a blanc   
```--diff``` pour voir la différence entre l'original et celui modifier  
Retirer ```--dry-run``` pour avoir les fichiers qui sont fixés automatiquement.  
On préférera utiliser les commandes faites avec composer pour gagner du temps :  
```composer "test:cs"``` pour voir quel fichier comporte des problèmes  
```composer "fix:cs"``` pour fixer les problèmes  

L'utilisation de Grumphp pour sniffer vos commits vous évitera les erreurs bêtes cependant si vous souhaitez changer de 
poste utiliser l'option `-n` au moment de git commits dans le terminal  

## Tests

Les Tests se font avec Phpunit avec ```composer test:phpunit```

## Installation dépendance  
  
* Le projet nécéssite composer, minimum php8.3 
* Lors d'un clonage du Git utiliser la commande ```composer install``` pour l'installation des paquets nécessaire au fonctionnement du projet dans /vendor/.  
Cela mettre également à jour l'auto chargement sinon utilisé ```composer dump-autoload```.  
* Pour configurer le lien avec la base de donnée, créer à la racine un fichier .mypdo.ini contenant :     
    ```
  [mypdo]  
  dsn = 'mysql:host=mysql;dbname=Nom-de-la-BD;charset=utf8'  
  username = 'Identifiant'  
  password = 'Mot-de-passe'
  ```  
* Pour l'Intégration de php-Fixer dans phpStorm se fait dans ___Settings (CTRL+ALT+S)\Php\Quality_Tools\Php cs fixer - Rulesets : custom + chemin vers.php-cs-Fixer.php + mettre sur ON___
Et ne pas oublier de mettre dans ___Settings\Php\Quality_Tools de mettre php-cs-fixer dans External formatter___.

### Installation composer -> linux
[https://getcomposer.org/download/](ici), pour le guide taper la commande composer

### Installation composer -> Window
Le fichier de setup est dans bin

## En cas d'erreur

#### erreur "Failed to listen on localhost:8000 (reason : address already in use)" -> linux.
Taper la commande ```ps -ef``` pour afficher les processus et cherchez le processus **php -d auto_prepend_files= __chemin d'accès de votre projet/vendor/auload.php__ -d display_errors -S localhost:8000 -t public/**
ou **bash bin/run_server.sh** regarder le pid et utiliser ```kill -9 <pid>``` .
#### Fatal error: Uncaught PDOException: PDO::__construct(): php_network_getaddresses: 
Verifier a bien etre connecter à la base de donnée avec un bon dsn, identifiant, mdp, et cela, avant de lancer le serveur local ou de le relancer