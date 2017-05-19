<?php
session_start();
require_once 'dao.php';
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$mdp = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$mdpsha = sha1($mdp);
$rep = readUser();
foreach ($rep as $row){
   if ($pseudo == $row['pseudoUtilisateur'] && $mdpsha == $row['mdpUtilisateur']) {
        $_SESSION['idUtilisateurConnecte'] = $row['idUtilisateur'];
   }
}
header("location: index.php");
