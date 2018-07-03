<?php
// Connexion à la BDD (PDO)
 $pdo = new PDO('mysql:host=localhost; dbname=boutique', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


// Ouverture de session
session_start();

// Définition de constantes
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . 'php-advance/boutique/');
define("URL", "http://localhost/php-advance/boutique/");

// Déclaration de variable
$content = '';

// Inclusion des fonctions
require_once('fonction.php');
