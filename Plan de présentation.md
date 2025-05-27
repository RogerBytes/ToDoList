### 🟦 Slide 1 – Introduction 1 à 2 min

- Harry Richmond, formation Développeur Web & Web Mobile
- Présentation d’un projet personnel pour valider le back-end
- Objectif : démontrer mes compétences serveur

---

### 🟦 Slide 2 – Présentation du projet 1 à 2 minutes

- Projet individuel, en contexte de rattrapage
- To-do list web simple mais complète
- Focus : PHP, données, sécurité, organisation

---

### 🟦 Slide 3 – Démo de l’application 3 à 5 minutes

- Connexion avec utilisateur existant
- Ajout, modification, suppression de tâches
- Stockage via PDO et requêtes préparées
- PhpMyAdmin accessible pour visualiser la BDD
- Docker : PHP/Apache, MariaDB, PhpMyAdmin

---

### 🟦 Slide 4 – Explications techniques 10 à 12 minutes

#### 🔐 Sécurité

- Authentification avec `password_hash()`
- Sessions et fonction `req_connect()`
- CSRF : token invisible généré et vérifié

#### 🗄️ Base de données (PDO)

- Connexion via PDO
- Requêtes préparées, résultats `FETCH_OBJ`
- Gestion des erreurs via try/catch

#### 🐳 Docker

- 3 conteneurs : PHP, MariaDB, PhpMyAdmin
- Variables dans `.env` (hors Git)
- Lancement portable & rapide

#### 🧱 Organisation

- Dossiers : `auth/`, `pages/`, `lib/`
- Code procédural + début de POO (`Post.php`)
- MVC envisagé pour plus tard

---

### 🟦 Slide 5 – Limites & améliorations  2 à 3 minutes

- Manque : inscription, captcha, blocage bruteforce
- Prévu : tables `failed_attempt`, `blocked_until`
- Projet volontairement minimaliste mais structuré

---

### 🟦 Slide 6 – Schéma MCD

- Présentation du schéma relationnel de la BDD
- Tables `users`, `posts`, + tables prévues pour la sécurité

---

### 🟦 Slide 7 – Conclusion 1 à 2 minutes

- Consolidation de mes bases PHP, SQL, sécurité, Docker
- Possibilités d’évolution : MVC, inscription, sécurité avancée
- Projet réalisé en autonomie, preuve de compétence réelle
