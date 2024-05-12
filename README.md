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

Un Dockerfile est un fichier texte qui contient des instructions pour construire une image Docker. Une image Docker est un modèle léger, autonome et exécutable qui inclut tout ce qui est nécessaire pour exécuter une application : le code, un runtime, des bibliothèques, des variables d'environnement et des fichiers de configuration.



 un `compose.yml` et un `Dockerfile` qui seront utilisés par docker via `docker compose`.

Définit trois services : web, mysql et phpmyadmin.
Le service web :
Construit l'image à partir du Dockerfile présent dans le répertoire courant (.).
Dépend du service mysql pour s'exécuter.
Utilise la redirection de port pour que le port 8851 de l'hôte soit mappé au port 80 du conteneur.
Montage d'un volume pour synchroniser le répertoire courant de l'hôte avec /var/www/html à l'intérieur du conteneur.
Définit des variables d'environnement pour la configuration de l'application web.
Le service mysql :
Utilise l'image mariadb, une variante populaire de MySQL.
Définit un mot de passe root pour la base de données.
Redirige le port 3851 de l'hôte vers le port 3306 du conteneur.
Le service phpmyadmin :
Utilise l'image phpmyadmin pour administrer la base de données MySQL/MariaDB.
Dépend du service mysql pour s'exécuter.
Configure l'accès à phpMyAdmin pour se connecter au service mysql.
Redirige le port 7851 de l'hôte au port 80 du conteneur.




---

## Auteurs

- [Harry RICHMOND](https://github.com/RogerBytes)
