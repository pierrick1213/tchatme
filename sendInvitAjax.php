<?php
session_start();
require_once 'dao.php';
$idUtilisateur = filter_input(INPUT_POST, 'idUtilisateur');
$texteDemande = filter_input(INPUT_POST, 'texteDemande');
if ($texteDemande == "") {
        $texteDemande = NULL;
    }
CreateInvitFriend($_SESSION['idUtilisateurConnecte'], $idUtilisateur, $texteDemande);




