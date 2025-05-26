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
docker compose up -d # Créé la pile de conteneurs
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
```

Si vous avez installer docker-engine avec

```bash
sudo nala install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

### Avec Docker-Engine

Si vous utilisez docker-engine au lieu de docker-desktop

```bash
sudo systemctl start docker # Lance le service de docker
docker compose start        # Lancer les conteneurs
docker compose stop         # Stopper les conteneurs
```

Par défaut `docker-desktop` va lancer tous nos conteneurs/piles de conteneurs (faisant ici l'équivalent d'un `docker compose start`)

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

## Représentation visuelle de l'architecture

```asci
todolist-app/
├── auth/
│   ├── login.php
│   └── logout.php
├── class/
│   └── Post.php
├── includes/
│   ├── elements/
│   │   ├── footer.php
│   │   └── header.php
│   └── functions.php
├── lib/
│   ├── auth.php
│   └── path.php
├── pages/
│   ├── delete.php
│   ├── edit.php
│   ├── index.php
│   └── todolist.php
└── index.php  → redirection vers pages/index.php
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

L'argument `'cost' => 14` est optionnel, il permet de définir le coût de hachage, c’est-à-dire la complexité de l’algorithme, rendant plus hardu le bruteforce du mdp pour un attaquant (en rendant plus longue la requête en demandant un calcul plus conséquent lors du décryptage).

`PASSWORD_DEFAULT` utilise bcrypt, l’algorithme de hachage par défaut.

## Interface d'abstraction PDO

Sur la [page d'extensions BDD de php](https://www.php.net/manual/fr/refs.database.php), j'utilise [PDO (PHP Data Object)](https://www.php.net/manual/fr/book.pdo.php)

### Base de donnée du projet

Via `PhpMyAdmin` je créé une base de donnée `todolist` en `utf8mb4_general_ci`

ou en CLI :

```sql
CREATE DATABASE `todolist` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */
```

et également la table `posts`

```sql
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  content TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Pour utiliser l'interface PDO de PHP :

```php
$pdo = new PDO('mysql:host=mysql;dbname=todolist;charset=utf8mb4', $user, $password);
```

`'mysql:host=mysql;dbname=todolist;charset=utf8mb4'`

Ceci est le DSN (Data Source Name), une chaîne de connexion qui indique à PDO comment se connecter à une base de données (type, hôte, nom, encodage, etc.).  
Dans `mysql:host=mysql`, le premier `mysql` désigne le type de SGBD (Système de Gestion de Base de Données) utilisé (ici MariaDB, compatible MySQL), alors que le second `mysql` correspond au nom de service dans le `compose.yml`.

Quand on instancie PDO, en 4e argument, on peut configurer le comportement, par exemple :

```php
$pdo = new PDO('mysql:host=mysql;dbname=todolist;charset=utf8mb4', $user, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
```

`PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` configure PDO pour lancer des exceptions en cas d’erreur SQL (au lieu de warnings silencieux).
Cela permet une gestion plus propre et plus robuste des erreurs avec try/catch.  
`PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ` définit le mode de récupération des résultats par défaut : chaque ligne sera un objet PHP (et non un tableau associatif). On accède alors aux colonnes via `$ligne->nom_colonne` au lieu de `$ligne['nom_colonne']`.

### Sécurité dans SQL

Dans ce `try/catch` :

```php
try {
  if (isset($_POST['name'], $_POST['content'])) {
    $query = $pdo->prepare('UPDATE posts SET name = :name, content = :content WHERE id = :id');
    $query->execute([
      'name' => $_POST['name'],
      'content' => $_POST['content'],
      'id' => (int)$_GET['id']
    ]);
  }
  $query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
  $query->execute(['id' => (int)$_GET['id']]); // le get id est ce que retourne le get dans l'adresse http, avec le int je limite ce que peut mettre manuellement l'user dedans
  $post = $query->fetch(); // ici je ne fetch qu'une seule ligne, vu que via la query sql, j'ai une condition sur la clé unique de id
} catch (PDOException $e) {
  $error = $e->getMessage();
}
```

Quand je prépare des requêtes (`$query`) afin de prévenir les injection sql, je passe par des marqueurs avec la syntaxe `:` dans les paramètres de la méthode `prepare`.

Ensuite via la méthode `execute` (qui lance la query), en paramètre, je passe via un tableau des valeurs au différents marqueurs.

Le `try/catch` me permet ici de gérer les erreurs () en utilisant la méthode `getMessage` (héritée) de la classe `PDOException`.

### Sécurité dans le HTML

J'utilise la function php `htmlentities()`, elle convertit les caractères spéciaux HTML (comme <, >, &, ") en entités (&lt;, &gt;, etc.), empêchant ainsi les injections de code malveillant dans la page.
Ceci empêche les attaques XSS (Cross-Site Scripting) en s'assurant que le contenu est affiché comme du texte, empêchant toute injection de HTML ou de JavaScript.

### Sécurité de connexion avec un .env

Dans le `compose.yml`
Dans les variable d'environnement du service `web` j'ai ces variables :

```yml
- DB_USER=${DB_USER}
- DB_PASSWORD=${DB_PASSWORD}
```

et dans les variable d'environnement du service `mysql` j'ai ces variables :

```yml
- MARIADB_ROOT_PASSWORD=${DB_PASSWORD}
```

Implicitement `${DB_USER}` et `${DB_PASSWORD}` seront interprétés comme les variables d’environnement correspondantes dans le fichier `.env` sous cette forme :

```env
DB_USER="root"
DB_PASSWORD="root"
```

⚠️ **Évitez ABSOLUMENT** d'utiliser des identifiants sensibles en clair dans un vrai projet.

On ajoute ce fichier dans le .gitignore (en ajoutant une ligne `.env` dans le `.gitignore`) pour éviter de l’exposer dans un dépôt Git. Lors du déploiement, le `.env` est ensuite injecté via Docker (placé au même niveau que le `docker-compose.yml`), par exemple avec un outil d’intégration continue.

### Implémentations tardives

#### CSRF

J'ai fait deux fonctions dans `lib.php`.

Pour les utiliser il faut insérer en début de script

```php
require_once path('/lib/csrf.php');
$local_token = csrf_token();
```

Et dans la condition d'execution des requêtes (derrière un &&) :

```php
csrf_check($_POST['csrf_token'])
```

Il me faut ajouter un input caché dans mes formulaires (si possible en premier).

```html
<input type="hidden" name="csrf_token" value="<?= $local_token ?>">
```

#### Limite de tentatives de connexion et table users

##### Créer une table users

Dans PhpMyAdmin, je crée la table `users`

- id (clé primaire auto-incrémentée)
- username (unique)
- password_hash
- failed_attempts (int)
- blocked_until (datetime, nullable)
- archived_at (datetime, nullable)

en CLI

```sql
CREATE TABLE `todolist`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(15) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `failed_attempt` INT NOT NULL DEFAULT 0,
  `blocked_until` DATETIME DEFAULT NULL,
  `archived_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`username`)
) ENGINE=InnoDB;
```

Et je modifie la table `posts` pour y lier une clef étrangère

```sql
ALTER TABLE posts ADD COLUMN user_id INT NULL AFTER id;
ALTER TABLE posts ADD COLUMN archived_at DATETIME DEFAULT NULL;
ALTER TABLE posts
  ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE users
  ADD COLUMN email VARCHAR(255) NOT NULL UNIQUE AFTER username;
```

Explication :
Ajouter la colonne user_id dans posts, nullable
Ajouter la colonne archived_at dans posts, nullable aussi
Ajouter la contrainte d''association de clé étrangère (et le delete en cascade, si un user est supprimé, ses post également)
Ajouter une colonne pour l'adresse mail

- Ajoute une colonne user_id de type entier (INT) non nulle à ta table posts
- Ajoute une colonne archived_at de type DATETIME en cas de suppression d'utilisateurs
- Ajoute une contrainte de clé étrangère (FOREIGN KEY) sur user_id qui référence la colonne id de la table users (en gros ça prend l'id de l'user)
- Configurer la contrainte pour que, si un utilisateur est supprimé, ses tâches soient aussi supprimées (ON DELETE CASCADE).

Attention de ce fait pour les select
je dois mettre
SELECT * FROM posts WHERE archived_at IS NULL
Sinon les message supprimés apparaîtront

et pour supprimer
UPDATE posts SET archived_at = NOW() WHERE id = :id
Pour archiver les message effacés

A faire

#### Inscription

A faire

#### Ajouter Captcha

A faire

#### Présenter MCD

