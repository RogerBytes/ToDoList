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

Afin de pouvoir facilement deployer le projet je créé un `compose.yaml` qui sera utilisé par docker via `docker compose`.

---

## Auteurs

- [Harry RICHMOND](https://github.com/RogerBytes)
