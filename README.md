# CakePHP Application for IMIE school

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

Pour installer le projet :

cloner le dépot :
```bash
git clone https://github.com/sammour/rgpd_project.git samson_rgpd_project
```

Installer avec composer :

```bash
composer install
```

Dans `config/app.php` pour trouver la configuration de la connexion à la base de données.
Vous trouverez un paramètre database, il faut le compléter avec le nom de la base de donnée mysql qui va être utilisée, il faut donc la créer.

Puis :

```bash
##Création des tables##
bin/cake migration migrate
##To start the build-in webserver##
bin/cake server -p 8766
```
