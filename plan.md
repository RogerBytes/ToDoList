# Plan

## 🧩 Structure du projet

```text
/ton-projet/
├── index.php          ← Affiche les tâches (lecture seulement)
├── db.php             ← Connexion PDO
├── register.php       ← Inscription
├── login.php          ← Connexion
├── logout.php         ← Déconnexion
├── add.php            ← Ajout de tâche (formulaire + insertion)
├── edit.php           ← Modification tâche
├── delete.php         ← Suppression tâche
├── /includes/
│   ├── header.php
│   └── footer.php
```

---

## 📆 Plan jour par jour

### 🟩 Lundi – Environnement + BDD + Auth

- Finir la vidéo Grafikart jusqu’à PDO
- Créer `users` et `tasks`
- Préparer `db.php`
- Créer `register.php` + `login.php` + gestion des sessions
- Rediriger vers `index.php` si connecté

### 🟩 Mardi – Lecture & Ajout

- Afficher les tâches de l’utilisateur connecté (`index.php`)
- Créer `add.php` pour ajouter une tâche liée à `user_id`
- Vérification d’auth sur toutes les pages

### 🟨 Mercredi – Modification / Suppression

- `edit.php` : formulaire pré-rempli, update
- `delete.php` : suppression sécurisée
- Afficher les boutons modifier/supprimer dans `index.php`

### 🟨 Jeudi – Style & Nettoyage

- Ajouter Bootstrap 4.1 (CDN)
- Structurer avec `header.php` / `footer.php`
- Vérifier toutes les fonctionnalités
- Affichage des messages de succès/erreur

### 🟥 Vendredi – Sécurité & Finalisation

- Vérifications : injections SQL, champs vides, droits
- Nettoyer le code
- Préparer une version .zip à rendre
- Optionnel : ajout d’un style personnalisé

---

## 🗃️ Tables SQL

**`users`**

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**`tasks`**

```sql
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  user_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```
