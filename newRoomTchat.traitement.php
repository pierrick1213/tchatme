<?php
session_start();
require_once 'dao.php';
if (isset($_POST['submit'])) {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
    $desc = filter_input(INPUT_POST, 'descritpion');
    $time = filter_input(INPUT_POST, 'time');
    $descritpion = preg_replace("(\r\n|\n|\r)", " ", $desc);

    $date = explode("-", $_POST['date']);
    if (strtotime($_POST['date']) > (strtotime(date('Y') . '-' . date('n') . '-' . date('j')))) {
        
    } else {
        header("location: newRoomTchat.php?erreur=date");
        exit();
    }
    CreateTchatRoomWithoutVignette($nom, $descritpion, $_POST['date'].' '.$time);
    $idTchat_room = MyPdo()->lastInsertId();
    $typeVignette = explode("/", $_FILES['vignette']['type']);
    if ($typeVignette[0]!= "image") {
        header("location: newRoomTchat.php?erreur=vignette");
        exit();
    }
    $vignette = $idTchat_room . "." . $typeVignette[1];
    UpdateTchatRoomVignette($vignette, $idTchat_room);

    $movepath = 'img/vignette/' . $vignette;
    move_uploaded_file($_FILES['vignette']['tmp_name'], $movepath);
    
    addUserInTchatRoom($idTchat_room, $_SESSION['idUtilisateurConnecte']);
    
        header("location: index.php");
} else {
    header("location: newRoomTchat.php");
}


