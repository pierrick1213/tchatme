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
function readUserNoFriend($pseudo, $idOfMe){
    $req = "SELECT * FROM utilisateurs WHERE idUtilisateur NOT IN (SELECT idUtilisateur FROM utilisateurs, sontamis where `idUtilisateur` = idUtilisateur_estAmi AND idUtilisateur_de = $idOfMe OR `idUtilisateur` = idUtilisateur_de AND idUtilisateur_estAmi = $idOfMe GROUP BY idUtilisateur HAVING COUNT(idUtilisateur)>= 1) AND idUtilisateur != $idOfMe AND pseudoUtilisateur like '%".$pseudo."%'";
        $sql = MyPdo()->prepare($req);
        $sql->execute();
        return $sql;
}
function readUserFriend($pseudo, $idOfMe){
    $req = "SELECT * FROM utilisateurs, sontamis where pseudoUtilisateur like '%" . $pseudo . "%' AND `idUtilisateur` = idUtilisateur_estAmi AND idUtilisateur_de = $idOfMe OR `idUtilisateur` = idUtilisateur_de AND idUtilisateur_estAmi = $idOfMe GROUP BY idUtilisateur HAVING COUNT(idUtilisateur)>1";
        $sql = MyPdo()->prepare($req);
        $sql->execute();
        return $sql;
}
function readIfUserIsFriendOrNot($idOfMe, $idUser){
    $req = "SELECT DISTINCT * FROM utilisateurs, sontamis where `idUtilisateur` = idUtilisateur_estAmi AND idUtilisateur_de = $idOfMe AND `idUtilisateur_estAmi` = $idUser OR `idUtilisateur` = idUtilisateur_de AND idUtilisateur_estAmi = $idOfMe AND `idUtilisateur_de` = $idUser";
    $sql = MyPdo()->prepare($req);
    $sql->execute();
    if ($sql->rowCount() == 2) {
        return 0;
    }
    else if($sql->rowCount() == 1)
    {
        return 1;
    }
    else if($sql->rowCount() == 0)
    {
        return 2;
    }
       
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
function CreateTchatRoomWithoutVignette($nom, $descritpion, $date){
    $req = "INSERT INTO `tchat_rooms`(`nomTchat_room`, `dureeVieTchat_room`, `descritpionTchat_room`) VALUES (:nom,:date,:descritpion)";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':nom', $nom);
    $sql->bindParam(':descritpion', $descritpion);
    $sql->bindParam(':date', $date);
    $sql->execute();
}
function UpdateTchatRoomVignette($vignette, $idTchatRoom){
    $req = 'UPDATE `tchat_rooms` SET `vignetteTchat_room`=:vignette WHERE `idTchat_room` = :idTchatRoom';
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':vignette', $vignette);
    $sql->bindParam(':idTchatRoom', $idTchatRoom);
    $sql->execute();
    
}
function DeleteTchatRoomById($idTchat_room){
    $req = "DELETE FROM `tchatme`.`tchat_rooms` WHERE `tchat_rooms`.`idTchat_room` = :idTchat_room";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam('idTchat_room', $idTchat_room);
    $sql->execute();
    
}
function addUserInTchatRoom($idTchat_room, $idOfMe){
    $req = "INSERT INTO `sontpresents`(`idUtilisateur`, `idTchat_room`) VALUES (:idOfMe,:idTchat_room)";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam('idTchat_room', $idTchat_room);
    $sql->bindParam('idOfMe', $idOfMe);
    $sql->execute();
}
function CreateInvitFriend($idOfMe, $idUser, $reason){
    $req = "INSERT INTO `sontamis`(`idUtilisateur_estAmi`, `idUtilisateur_de`, `raison`) VALUES (:idOfMe,:idUser,:reason)";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':idOfMe', $idOfMe);
    $sql->bindParam(':idUser', $idUser);
    $sql->bindParam(':reason', $reason);
    $sql->execute();
}
function readInvit($idOfMe){
    $req = "SELECT * FROM `sontamis`, utilisateurs WHERE `idUtilisateur_de` = :idOfMe1 AND idUtilisateur_estAmi not in (select idUtilisateur_de from sontamis WHERE `idUtilisateur_estAmi` = :idOfMe2) AND idUtilisateur_estAmi = idUtilisateur";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':idOfMe1', $idOfMe);
    $sql->bindParam(':idOfMe2', $idOfMe);
    $sql->execute();
    return $sql;
}
function AcceptInvit($idOfMe, $idUser){
    $req = "INSERT INTO `sontamis`(`idUtilisateur_estAmi`, `idUtilisateur_de`) VALUES (:idOfMe,:idUser)";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':idOfMe', $idOfMe);
    $sql->bindParam(':idUser', $idUser);
    $sql->execute();
    return $sql;
}
function RefuseInvit($idOfMe, $idUser){
    $req = "DELETE FROM `sontamis` WHERE `idUtilisateur_de` = :idOfMe  and `idUtilisateur_estAmi` = :idUser";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':idOfMe', $idOfMe);
    $sql->bindParam(':idUser', $idUser);
    $sql->execute();
    return $sql;
}
function DeleteFriend($idOfMe, $idUser){
    $req = "DELETE FROM `sontamis` WHERE `idUtilisateur_estAmi` = :idOfMe1 AND `idUtilisateur_de` = :idUser1 OR `idUtilisateur_estAmi` = :idUser2 AND `idUtilisateur_de` = :idOfMe2";
    $sql = MyPdo()->prepare($req);
    $sql->bindParam(':idOfMe1', $idOfMe);
    $sql->bindParam(':idOfMe2', $idOfMe);
    $sql->bindParam(':idUser1', $idUser);
    $sql->bindParam(':idUser2', $idUser);
    $sql->execute();
    return $sql;
}