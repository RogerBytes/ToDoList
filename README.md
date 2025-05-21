# TodoList

## Prérequis

- git
- docker
- php

## En cas de ralentissement avec Docker

Je ne sais pas pourquoi mais il arrive que Docker ralentisse lourdement l'environnement graphique, du moins sur Cinnamon, voici comment le relancer

```bash
nohup cinnamon --replace >/dev/null 2>&1 &
```

### Déploiement local avec Docker

Présentement je ne vais pas détailler les fichiers `compose.yml` (qui génère les conteneurs) et `Dockerfile` (qui sert au compose via la directive `build`) afin de rendre la mise en place du projet plus rapide, ce sera détaillé quand le projet sera fini, en fin de documentation.

Déploiement :

```bash
docker compose up -d
sleep 2
docker compose stop
volume_path=$(grep -oP '(?<=- ./)[^:]*' compose.yml)
[ ! -f "$volume_path/index.php" ] && echo "<?php\necho 'Hello, World!';\n?>" > "$volume_path/index.php"
```

Ca génère le dossier `ToDoList` et également un fichier index.php avec un "Hello World" le projet est vierge.

`up` c'est pour mettre les conteneurs en place, `down` va carrément supprimer les conteneurs.

## Démarrer l'application en local

On lance docker-desktop et le conteneur docker avec :

```sh
/opt/docker-desktop/bin/docker-desktop
sleep 7
docker compose start
```

Et quand on souhaite stopper l'execution du conteneur :

```bash
docker compose stop
```

Complètement arrêter tous les services Docker (et relancer l'environnement graphique cinnamon)

```bash
docker stop $(docker ps -a -q)
sudo systemctl stop docker.service
sudo systemctl stop docker.socket
systemctl --user stop docker-desktop
pkill -f docker-desktop
nohup cinnamon --replace >/dev/null 2>&1 &
```

Pour afficher dans le navigateur :

```html
http://localhost:8851
```

Car le port 8851 est spécifié dans le compose.yml

Pour le suivi de la [formation PHP de Grafikart](https://youtube.com/playlist?list=PLjwdMgw5TTLVDv-ceONHM_C19dPW1MAMD) j'ai utilisé bootstrap 4.1 via nodejs (dans le répertoire `todolist-app` ) avec

Au [chapitre 12](https://youtu.be/_WprUvG1mbs?list=PLjwdMgw5TTLVDv-ceONHM_C19dPW1MAMD), faire un `cd todolist-app` pour être dans le bon repertoire et quand il est question de récupérer le template allez sur [cette page d'exemples](https://getbootstrap.com/docs/4.1/examples/), pour y trouver [notre version du Starter Template](https://getbootstrap.com/docs/4.1/examples/starter-template/).

Pour le lier j'ai mis dans le header indiqué [sur la doc de BS 4.1](https://getbootstrap.com/docs/4.1/getting-started/introduction/).

```html
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
  crossorigin="anonymous"
/>
```

Et dans le footer

```html
<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
  crossorigin="anonymous"
></script>
<script
  src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
  crossorigin="anonymous"
></script>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
  crossorigin="anonymous"
></script>
```

## PhpMyAdmin

En se basant sur les infos du `compose.yml`

### Adresse

```yml
ports:
  - "7851:80"
```

Donc le port est `7851`

```http
http://localhost:7851/
```

### Connexion

#### Avertissement

```yml
environment:
  - DB_USER=root
  - DB_PASSWORD=root
```

Attention, cela ne définit pas le nom d'user ni le mot de passe, c'est juste deux variables qu'on peut appeler dans php.

#### Serveur

`PMA_HOST: mysql` -> donc le serveur est `mysql`

#### Utilisateur

C'est `- MARIADB_ROOT_PASSWORD=root` via l'image de MariaDB qui créé l'utilisateur `root`. Le nom `root` est réservé pour l’administrateur principal. Vous pouvez ajouter un autre utilisateur, mais pas renommer root.

#### Mot de passe

C'est `- MARIADB_ROOT_PASSWORD=root` donne le mot de passe `root` à l’utilisateur `root`.

#### Résumé

- Serveur = `mysql`
- Utilisateur = `root`
- Mot de passe = `root`

## Sécurisation et connexion

J'ai vu l'utilisation de la fonction php `password_hash()` utilisée tel que :

```php
$hashed_password = password_hash($password, PASSWORD_DEFAULT, 'cost' => 14);
```

L'argument `'cost' => 14` est optionnel, il permet de définir le coût de hachage, c’est-à-dire la complexité de l’algorithme, rendant plus hardu le bruteforce du mdp pour un attaquant (rendant également plus longue la requête en demandant un calcul plus conséquent).

`PASSWORD_DEFAULT` utilise bcrypt, l’algorithme de hachage par défaut.

## Interface d'abstraction PDO

Sur la [page d'extensions BDD de php](https://www.php.net/manual/fr/refs.database.php), j'utilise [PDO (PHP Data Object)](https://www.php.net/manual/fr/book.pdo.php)

### Base de donnée du projet

Via `PhpMyAdmin` je créé une base de donnée `todolist` en `utf8mb4_general_ci`

ou en CLI :

```sql
CREATE DATABASE `todolist` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */
```

Pour utiliser l'interface PDO de PHP :

```php
$pdo = new PDO('mysql:host=mysql;dbname=todolist;charset=utf8mb4', $user, $password);
```

`'mysql:host=mysql;dbname=todolist;charset=utf8mb4'`

Ceci est DSN (Data Source Name), une chaîne de connexion qui indique à PDO comment se connecter à une base de données (type, hôte, nom, encodage, etc.).
Dans `mysql:host=mysql`, le premier `mysql` désigne le type de SGBD (Système de Gestion de Base de Données) utilisé (ici MariaDB, compatible MySQL), alors que le second `mysql` correspond au nom de service dans le `compose.yml`.
