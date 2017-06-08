<?php
session_start();
require_once 'function.php';
verifConnecte();
require_once 'dao.php';

AcceptInvit($_SESSION['idUtilisateurConnecte'], $_GET['idUtilisateur']);
header("location: users.php");

