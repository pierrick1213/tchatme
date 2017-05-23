<?php
require_once("configDB.php");

function MyPdo() {
    static $dbc = NULL;
    try {
        if ($dbc == NULL) {
            $dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USER, DB_PWD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION));
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    return $dbc;
}
function readUser(){
    $req = "SELECT * FROM `utilisateurs`";
    $sql = MyPdo()->prepare($req);
    $sql->execute();
    return $sql;
}
function readUserById($idUtilisateur){
    $req = "SELECT `nomUtilisateur`, `prenomUtilisateur`, `pseudoUtilisateur`, `emailUtilisateur`, `avatarUtilisateur` FROM `utilisateurs` WHERE `idUtilisateur` = :idUtilisateur";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':idUtilisateur', $idUtilisateur);
    $sql->execute();
    return $sql;
}
function CreateUser($prenom, $nom, $pseudo, $email, $mdp, $avatar) {
    $req = "INSERT INTO `utilisateurs`(`nomUtilisateur`, `prenomUtilisateur`, `pseudoUtilisateur`, `emailUtilisateur`, `mdpUtilisateur`, `avatarUtilisateur`) VALUES (:nom,:prenom,:pseudo,:email,:mdp,:avatar)";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':prenom', $prenom);
    $sql->bindParam(':nom', $nom);
    $sql->bindParam(':pseudo', $pseudo);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':mdp', $mdp);
    $sql->bindParam(':avatar', $avatar);
    $sql->execute();
}
function readTchat_roomByUserId($idUtilisateur){
    $req = "SELECT tchat_rooms.`idTchat_room`, `nomTchat_room`, `dureeVieTchat_room`, `descritpionTchat_room`, `vignetteTchat_room` FROM `tchat_rooms`,`sontpresents` WHERE tchat_rooms.`idTchat_room` = sontpresents.`idTchat_room` AND idUtilisateur = :idUtilisateur";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':idUtilisateur', $idUtilisateur);
    $sql->execute();
    return $sql;
}
