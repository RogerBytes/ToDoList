# TodoList

Une application de gestion de tâches (todolist) qui permet aux utilisateurs de gérer efficacement leurs tâches quotidiennes. L'application offre des fonctionnalités pour ajouter et retirer des tâches d'une base de données, assurant la persistance des données. En outre, elle intègre un système d'authentification permettant aux utilisateurs de se connecter et de se déconnecter, garantissant ainsi la sécurité et la personnalisation de l'expérience utilisateur.

## Mise en place du projet

### Repo local et distant

Pour créer mon repo git local :
`git init`

Créer mon repo distant :
`gh repo create RogerBytes/ToDoList --public`

Je lie le remote (en gros ça synchronise le repo local sur le distant) :
`git remote add origin git@github.com:RogerBytes/ToDoList.git`

Je fais mon premier commit (en ayant un fichier "README.md") :
`git add --all && git commit -m "First commit"`

Puis mon premier push (en lui disant de passer sur le repo distant) :
`git push --set-upstream origin master`

### Container docker

Afin de pouvoir facilement deployer le projet j'utilise Docker.

Le `Dockerfile` est utilisé pour créer une ou plusieurs images Docker personnalisées. Ces images définissent l'environnement de l'application, y compris le système d'exploitation de base, les logiciels installés, les fichiers de votre application, les variables d'environnement, et plus encore.

Le fichier `docker-compose.yml` est utilisé pour définir et exécuter une pile de conteneurs Docker (multi-conteneurs). Ces conteneurs sont des instances en cours d'exécution créées à partir des images Docker. Docker Compose vous permet de configurer plusieurs conteneurs à la fois, de les relier ensemble, de configurer des volumes, des réseaux, etc.

#### Dockerfile

Ce `Dockerfile` crée une image Docker personnalisée basée sur l'image officielle `php:8.2-apache`. L'image résultante est configurée pour exécuter une application PHP avec le serveur web Apache et supporte l'utilisation des bibliothèques graphiques et la connexion à une base de données MySQL. Voici le détail des instructions :

- `FROM php:8.2-apache`  
  Définit l'image de base comme `php:8.2-apache`, qui inclut PHP 8.2 et le serveur web Apache prêt à l'emploi.

- `RUN apt update && apt upgrade -y`  
  Met à jour la liste des packages et effectue une mise à niveau des packages installés pour obtenir les dernières versions de sécurité et de fonctionnalités.

- `RUN apt install -y libfreetype6-dev`  
  Installe les dépendances nécessaires pour la compilation des extensions PHP, spécifiquement `libfreetype6-dev` pour le support des polices dans les graphiques.

  `&& docker-php-ext-configure gd --with-freetype=/usr/include/freetype2/`  
  Configure l'extension GD de PHP pour utiliser la bibliothèque FreeType pour le rendu des polices.

  `&& docker-php-ext-install pdo_mysql gd`  
  Installe les extensions PHP `pdo_mysql` pour la connexion à MySQL et `gd` pour les fonctionnalités graphiques.

- `RUN apt install -y libcurl4-openssl-dev pkg-config libssl-dev`  
  Installe les bibliothèques nécessaires pour utiliser le support SSL dans PHP et pour les besoins de CURL avec OpenSSL.

- `RUN a2enmod rewrite`  
  Active le module Apache `rewrite`, ce qui permet d'utiliser les fichiers `.htaccess` pour la réécriture d'URL, une fonctionnalité courante dans les applications web.

- `# COPY . /var/www/html`  
  La ligne est commentée, mais si elle était active, elle copierait les fichiers de l'application dans le répertoire `/var/www/html` du conteneur, qui est le document root d'Apache.

- `EXPOSE 80`  
  Indique que le conteneur écoute sur le port 80, le port HTTP par défaut, ce qui permettra aux clients de se connecter au service web Apache.

#### docker-compose

##### Serveur Web (`web`)

- **Contexte de Construction de l'Image** : Le répertoire courant (`.`), où se trouve le `Dockerfile` pour construire l'image personnalisée du serveur Apache avec PHP.
- **Dépendances** : Ce service dépend du service `mysql`, ce qui signifie que le service `mysql` sera démarré en premier.
- **Nom du Conteneur** : `serverApache851` est le nom donné au conteneur du serveur web.
- **Redémarrage** : Le conteneur sera redémarré automatiquement à moins qu'il ne soit arrêté manuellement (`unless-stopped`).
- **Ports** : Le port 80 du conteneur (port par défaut d'Apache) est mappé sur le port 8851 de l'hôte.
- **Volumes** : Le répertoire `/todolist-app/` est monté dans le conteneur au chemin `/var/www/html`, permettant la synchronisation des fichiers entre l'hôte et le conteneur.
- **Variables d'Environnement** : Configuration de l'environnement Apache et des paramètres de connexion à la base de données MySQL.

##### Base de Données MySQL (`mysql`)

- **Image** : Utilise l'image `mariadb`, une variante populaire de MySQL.
- **Nom du Conteneur** : `serverMySQL851` est le nom attribué au conteneur de la base de données.
- **Redémarrage** : Le conteneur redémarrera automatiquement sauf si arrêté manuellement.
- **Variables d'Environnement** : Définit le mot de passe root de MariaDB pour l'accès à la base de données.
- **Ports** : Le port 3306 du conteneur (port par défaut de MySQL) est mappé sur le port 3851 de l'hôte.

##### phpMyAdmin (`phpmyadmin`)

- **Image** : Utilise l'image `phpmyadmin` pour fournir une interface web de gestion de la base de données MySQL.
- **Nom du Conteneur** : `serverPHPMyAdmin851` est le nom donné au conteneur phpMyAdmin.
- **Redémarrage** : Le conteneur redémarrera automatiquement sauf si arrêté manuellement.
- **Dépendances** : Ce service dépend du service `mysql`, garantissant que phpMyAdmin peut se connecter à la base de données.
- **Variables d'Environnement** : Configure phpMyAdmin pour se connecter au service `mysql`.
- **Ports** : Le port 80 du conteneur (port par défaut de phpMyAdmin) est mappé sur le port 7851 de l'hôte.

#### Mise en route

J'utilise compose up pour le lancer la première fois, l'option `-d` le lance en arrière plan en "detached", le processus ne s'arrête pas si je ferme le terminal. Il va tout configurer en fonction de ces deux fichiers.

```sh
docker compose up -d
```

Ensuite pour l'arrêter j'utilise

```sh
docker compose stop
```

et pour le lancer

```sh
docker compose start
```

Si je veux complètement supprimer les conteneurs et la pile.

```sh
docker compose down
```

### Installer Composer dans un container de Docker

Composer est un gestionnaire de dépendances pour PHP qui permet aux développeurs d'installer et de gérer les bibliothèques dont leur projet a besoin.

Je l'installe ici dans "serverApache851" comme container.

Dans un shell il faut aller dans le container de docker.

```bash
docker exec -it serverApache851 bash
# Pour sortir du nested shell (shell imbriqué) il faut utiliser la commande "exit"
```

Il y a une particularité au projet, l'index.php n'est pas à la racine du dossier mais dans le dossier "public". Il faut changer la directive `DocumentRoot` d'apache. Je dois modifier `/etc/apache2/sites-available/000-default.conf`

Il faut lancer le conteneur en sudo avec :

```sh
docker exec -u 0 -it serverApache851 bash
```

```sh
chmod 644 /etc/apache2/sites-available/000-default.conf
nano /etc/apache2/sites-available/000-default.conf
```

Il faut ajouter `/public` au chemin, ça donne :

```sh
DocumentRoot /var/www/html/public
```

Ensuite, quitter et sauver avec `CTRL+X`puis `Y`. Après avoir arrêté et relancé le compose, la modification est prise en compte.

Ensuite j'installe les dépendances (je me sers de "nala", une surcouche d'apt, pour avoir un retour plus clair et lisible) :

```bash
apt install -y nala
nala update
nala install -y zip unzip 7zip libzip-dev && docker-php-ext-install zip
```

### Afficher le le projet dans le navigateur

Il suffit de se rendre à l'adresse `http://localhost:8851/`.

## Configuration de la base de données

Je me connecte au container avec

```sh
docker exec -it serverMySQL851 bash
```

Dans le nested shell, je me connecte à maria db avec

```sh
mariadb -u root -p
# Pour quitter le client de mariaDB, il faut utiliser la commande "quit"
```

et tape le mot de passe ("root" en l’occurrence).

Je crée une base de données "todolist"

```sql
CREATE DATABASE todolist;
```

et la sélectionne

```sql
USE todolist;
```

Je crée la table users

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('standard', 'admin') NOT NULL DEFAULT 'standard'
);
```

et la table tasks

```sql
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    is_complete BOOLEAN NOT NULL DEFAULT FALSE,
    due_date DATE NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

Je m'insère en tant qu'admin

```sql
INSERT INTO users (name, email, password, role) VALUES ('RogerBytes', 'rogerbytes@vivaldi.net', 'root', 'admin');
```

Pour les tester j'ai fait :

```sql
INSERT INTO users (name, email, password, role) VALUES ('Alice', 'alice@example.com', 'password123', 'standard');
INSERT INTO tasks (user_id, title, description, is_complete, due_date) VALUES (2, 'Acheter des chaussettes', 'Mes chaussettes sont toutes trouées', FALSE, '2024-03-10');
-- et je les affiche
SELECT * FROM users;
SELECT * FROM tasks;
-- et je les supprime
DELETE FROM tasks WHERE user_id = 2;
DELETE FROM users WHERE id = 2;
```

## Auteurs

- [Harry RICHMOND](https://github.com/RogerBytes)
