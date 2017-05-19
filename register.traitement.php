<?php
require_once 'dao.php';
$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$mdp1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_SPECIAL_CHARS);
$mdp2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);
$mdpsha = sha1($mdp1);
$avatar = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS).explode("/", $_FILES['imageUpload']['type'][$i])[1];

if ($pseudo != NULL && $mdp1 != NULL && $mdp2 != NULL && $prenom != NULL && $nom != NULL && $email != NULL && $avatar != NULL) {
    $rep = readUser();
    foreach ($rep as $row) {
    if ($pseudo == $row["pseudoUtilisateur"]) {
        header("location: register.php?erreur=pseudoExist");
        exit;
    }
    if ($email == $row["emailUtilisateur"]) {
        header("location: register.php?erreur=emailExist");
        exit;
    }
    if ($mdp1 != $mdp2) {
        header("location: register.php?erreur=notSameMdp");
        exit;
    }
    }
    move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/avatar/'.$avatar);
    CreateUser($prenom, $nom, $pseudo, $email, $mdpsha, $avatar);
    header('location:login.php');
}
else{
    header("location: register.php");
        exit;
}