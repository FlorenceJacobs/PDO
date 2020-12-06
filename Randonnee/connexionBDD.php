<?php
//Données connexion BD
$servname = "localhost";
$dbname = "randonnees";
$user = "Florence";
$pass = "florence";

// Connexion PDO
try {
    $strConnection = "mysql:host=$servname;dbname=$dbname";
    $arrExtraParam= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    $pdo = new PDO($strConnection, $user, $pass, $arrExtraParam);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDO::ERRMODE_EXCEPTION - lance une exception.
}
catch(PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}

// Récupérer toutes les données retournées
// $donnees = $prep->fetchAll();
// foreach($donnees as $donnee)
// {
?>