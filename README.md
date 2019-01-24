# CakePHP Application

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

Pour installer le projet :

cloner le dépot :
```bash
git clone https://github.com/sammour/rgpd_project.git sambmour_rgpd_project
```

Installer avec composer :

```bash
composer install
```

Dans `config/app.php` pour trouver la configuration de la connexion à a base de données. 

Puis :

```bash
bin/cake migration migrate
##To start the build-in webserver##
bin/cake server -p 8766
```
