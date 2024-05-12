<?php

require_once __DIR__.'/router.php';

get("/", "./index.php");
// Ici je fais tout l'index corrigé (parce qu'avec le routeur ça ne marche plus)

// ---------------- Syntaxe ------------------------
get("/variables", "./01-syntaxe/01-variable.php");
get("/conditions", "./01-syntaxe/02-condition.php");
get("/boucles", "./01-syntaxe/03-boucle.php");
get("/fonctions", "./01-syntaxe/04-fonction.php");
get("/include", "./01-syntaxe/05-include.php");
get("/session/a", "./01-syntaxe/06-a-session.php");
get("/session/b", "./01-syntaxe/06-b-session.php");
get("/date", "./01-syntaxe/07-date.php");
get("/header/a", "./01-syntaxe/08-a-header.php");
get("/header/b", "./01-syntaxe/08-b-header.php");

// ----------------- FORM ----------------------
get("/get", "./02-form/01-get.php");
any("/post", "./02-form/02-post.php");
get("/file", "./02-form/03-file.php");
get("/login", "./02-form/04-connexion.php");
get("/logout", "./02-form/05-deconnexion.php");
get("/security", "./02-form/06-security.php");

// ----------------- SERVICE ---------------
get("/captcha", "./ressources/services/_captcha.php");

// ----------------- CRUD ----------------------
// Liste utilisateur
get("/userlist", function(){
  require "./03-crud/controller/UserController.php";
  listUsers();
});

// Inscription
any("/register", function(){
  require "./03-crud/controller/UserController.php";
  inscription();
});

// Suppression d'un user
any("/account/delete", function(){
  require "./03-crud/controller/UserController.php";
  deleteUser();
});

// Modification d'un user
any("/account/edit", function(){
  require "./03-crud/controller/UserController.php";
  updateUser();
});

// Connexion
any("/connect", function(){
  require "./03-crud/controller/AuthController.php";
  connect();
});

// déconnexion
any("/disconnect", function(){
  require "./03-crud/controller/AuthController.php";
  disconnect();
});

// Accès à l'exercice
get("/exercice/my-version", "./03-crud/exercice/mon-essai/index.php");

// ----------------- SERVICE ---------------
get("/captcha", "./ressources/services/_captcha.php");

// Page de 404
any ("/404", "./404.php");



// -----------------------------------! VACANCES DE NOLWENN

get("/namespace", "./04-vacances-nolween/Exercice-namespace/index.php");