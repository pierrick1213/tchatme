<?php

session_start();
require_once 'dao.php';

function navBar($active) {
    $return = "";
    foreach (readUserById($_SESSION['idUtilisateurConnecte']) as $user) {

        $return .= '<div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container"> 
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>
                    <a class="navbar-brand">Tchat’me</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">';
        if (verifAdmin()) {
            switch ($active) {
            case 0:
                $return.= '<li><a href="index.php">Mes salles de tchat</a></li>'
                        . '<li><a href="users.php">Les membres</a></li>';
                break;
            case 1:
                $return.= '<li class="active"><a href="roomTchatAdmin.php">Les salles de tchat</a></li>'
                        . '<li><a href="users.php">Les membres</a></li>';
                break;
            case 3:
                $return.= '<li><a href="roomTchatAdmin.php">Les salles de tchat</a></li>'
                        . '<li class="active"><a href="users.php">Les membres</a></li>';
                break;
        }
        }
        else{
        switch ($active) {
            case 0:
                $return.= '<li><a href="index.php">Mes salles de tchat</a></li>'
                        . '<li><a href="otherRoomTchat.php">Autres salles disponibles</a></li>'
                        . '<li><a href="users.php">Les membres</a></li>';
                break;
            case 1:
                $return.= '<li class="active"><a href="index.php">Mes salles de tchat</a></li>'
                        . '<li><a href="otherRoomTchat.php">Autres salles disponibles</a></li>'
                        . '<li><a href="users.php">Les membres</a></li>';
                break;
            case 2:
                $return.= '<li><a href="index.php">Mes salles de tchat</a></li>'
                        . '<li class="active"><a href="otherRoomTchat.php">Autres salles disponibles</a></li>'
                        . '<li><a href="users.php">Les membres</a></li>';
                break;

            case 3:
                $return.= '<li><a href="index.php">Mes salles de tchat</a></li>'
                        . '<li><a href="otherRoomTchat.php">Autres salles disponibles</a></li>'
                        . '<li class="active"><a href="users.php">Les membres</a></li>';
                break;
        }
        }
        $return.= '</ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <strong>' . $user["prenomUtilisateur"] . '</strong>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center">
                                                    <img width="100" height="100" src="img/avatar/' . $user["avatarUtilisateur"] . '" alt="">
                                                </p>
                                            </div>
                                            <div class="col-lg-8">
                                                <p class="text-left"><strong>' . $user["prenomUtilisateur"] . ' ' . $user["nomUtilisateur"] . '</strong></p>
                                                <p class="text-left small">' . $user["emailUtilisateur"] . '</p>
                                                <p class="text-left">
                                                    <a href="profil.php" class="btn btn-primary btn-block btn-sm">Profil</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider navbar-login-session-bg"></li>
                                <li class="navbar-login-session-bg">
                                    <div class="navbar-login navbar-login-session">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                    <a href="login.php" class="btn btn-danger btn-block">Déconnexion</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider navbar-login-session-bg"></li>
                                <li><p  style="text-decoration: underline;" class="text-left"><strong>Demandes d\'amis</strong></p>
                                <p class="text-left small">
                                <table class="table table-bordered" style="border: 0;border-collapse: collapse;">
                    <tbody >';
        foreach (readInvit($_SESSION['idUtilisateurConnecte']) as $invit) {
            $return .='<tr>
                                <td style="padding: 0;border: 1px solid white;"><img width="50" height="50" src="img/avatar/' . $invit["avatarUtilisateur"] . '"></td>
                                <td title="' . $invit['raison'] . '" style="padding: 0;border: 1px solid white;"><a href="profil.php?idUtilisateur=' . $invit['idUtilisateur'] . '">' . $invit['pseudoUtilisateur'] . '</a></td>
                                <td style="padding: 0;border: 1px solid white;"><img onclick="acceptInvit(' . $invit['idUtilisateur'] . ')" width="10" height="10" src="img/icon/checked.svg"></td>
                                <td style="padding: 0;border: 1px solid white;"><img onclick="refuseInvit(' . $invit['idUtilisateur'] . ')" width="10" height="10" src="img/icon/cancel.svg"></td>
                        </tr>';
        }
        $return .=' </tbody>
                    </table>
                    </p></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div><br><br>';
    }
    return $return;
}

function verifConnecte() {
    if (!isset($_SESSION['idUtilisateurConnecte'])) {
        header("location: login.php?erreur");
    }
}

function verifIdUser() {
    if (isset($_GET['idUtilisateur'])) {
        if ($_GET['idUtilisateur'] == $_SESSION['idUtilisateurConnecte']) {
            header("location: profil.php");
        }
    }
}
function verifAdmin(){
    if ($_SESSION['idUtilisateurConnecte'] == 1) {
        return true;
    }
 else {
        return false;
    }
}

function verifTchatRoom() {
    if (!verifAdmin()) {
        
    
    if (!isset($_GET['idTchat_room'])) {
        header("location: index.php");
        exit();
    }
    $present = 0;
    foreach (readSontPresentsByUser($_SESSION['idUtilisateurConnecte']) as $row) {
        if ($_GET['idTchat_room'] == $row['idTchat_room']) {
            $present = 1;
        }
    }
    if ($present == 0) {
        header("location: index.php");
        exit();
    }
    }
}

function profil() {
    if (isset($_GET['idUtilisateur'])) {
        $idUtilisateur = $_GET['idUtilisateur'];
    } else {
        $idUtilisateur = $_SESSION['idUtilisateurConnecte'];
    }
    $return = "";
    foreach (readUserById($idUtilisateur) as $user) {
        $return.='<div class="container" style="text-align: center;">
            <img width="250" height="250" src="img/avatar/' . $user["avatarUtilisateur"] . '">
            <h2><strong>Nom : </strong>' . $user['nomUtilisateur'] . '</h2>
            <h2><strong>Prénom : </strong>' . $user['prenomUtilisateur'] . '</h2>
            <h2><strong>Pseudo : </strong>' . $user['pseudoUtilisateur'] . '</h2>
            <h2><strong>Email : </strong>' . $user['emailUtilisateur'] . '</h2>';

        if (isset($_GET['idUtilisateur'])) {
            if (!verifAdmin()) {

            if ($_GET['idUtilisateur'] == 1) {
                $return .= '';
            }
            else if (readIfUserIsFriendOrNot($_SESSION['idUtilisateurConnecte'], $idUtilisateur) === 0) {
                $return .='<a href="javascript:deleteFriend(' . $_GET['idUtilisateur'] . ', true)" class="btn btn-danger">Supprimer de mes amis</a>';
            } else if (readIfUserIsFriendOrNot($_SESSION['idUtilisateurConnecte'], $idUtilisateur) === 2) {
                $return .='<a href="javascript:sendInvitText(' . $_GET['idUtilisateur'] . ', true)" class="btn btn-primary">Ajouter en tant qu\'ami</a>';
            } else if (readIfUserIsFriendOrNot($_SESSION['idUtilisateurConnecte'], $idUtilisateur) === 1) {
                $return .= 'En attente de l\'acceptation de la demande';
            } 
            }  else {
                $return .='<a href="javascript:deleteUser(' . $_GET['idUtilisateur'] . ', true)" class="btn btn-danger">Supprimer des membres</a>';
            }
        }
         else {
            $return .= '<a href="" class="btn btn-success">Modifier Profil</a>';
        }
        
        $return .='</div>';
    }
    return $return;
}

function newTchatRoom() {
    $return = "";
    $return.= '<div class="container">
            <h1 style="text-align: center;padding-bottom: 20px;">Création d\'une nouvelle salle de tchat</h1>
            <form action="newRoomTchat.traitement.php" method="post" id="formNewTchatRoom" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="inputNameOfTchatRoom" class="col-sm-2 col-form-label">Nom de la salle :</label>
                    <div class="col-sm-10">
                        <input name="nom" type="text" class="form-control" id="inputNameOfTchatRoom" placeholder="Nom" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDescriptionOfTchatRoom" class="col-sm-2 col-form-label">Description de la salle :</label>
                    <div class="col-sm-10">
                        <textarea name="descritpion" style="resize:none;" class="form-control" id="inputDescriptionOfTchatRoom" placeholder="Description" form="formNewTchatRoom" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDateOfTchatRoom" class="col-sm-2 col-form-label">Date de la fin de la salle :</label>
                    <div class="col-sm-10">
                        <input style="width:50%;display: inline;" name="date" type="date" class="form-control" id="inputDateOfTchatRoom" required>
                        <input style="width:49%;display: inline;" name="time" type="time" class="form-control" id="inputDateOfTchatRoom" required>';

    if (isset($_GET['erreur'])) {
        if ($_GET['erreur'] == "date") {
            $return.= '<p id="erreurRegister">Veuillez entrer une date supérieur à la date d\'aujourd\'hui et pas trop loin</p>';
        }
    }
    $return.= '</div>
                </div>
                <div class="form-group row">
                    <label for="inputVignetteOfTchatRoom" class="col-sm-2 col-form-label">Choix d\'une vignette pour la salle :</label>
                    <div class="col-sm-10">
                        <input name="vignette" type="file" class="form-control" id="inputVignetteOfTchatRoom" accept="image/*" required>';

    if (isset($_GET['erreur'])) {
        if ($_GET['erreur'] == "vignette") {
            $return.= '<p id="erreurRegister">Veuillez entrer une image compatible</p>';
        }
    }

    $return.= '</div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center" >
                        <input name="submit" style="width: 50%; margin: auto;" type="submit" class="form-control" id="submit">
                    </div>
                </div>
            </form>
        </div>';

    return $return;
}

/**
 * 
 * @return string
 */
function tchatRoom() {
    $return = "";
    foreach (readTchat_roomById($_GET['idTchat_room']) as $tchat_room){
    $return.= '<div class="container bootstrap snippet">
            <div class="row">
                <div class="col-md-6" style="display: inline-block!important;">
                    <div class="portlet portlet-default">
                        <div class="portlet-heading">
                            <div class="portlet-title">    
                                <h4><i class="fa fa-circle text-green"></i><img src="img/vignette/'.$tchat_room['vignetteTchat_room'].'" width="50" ></img>'.$tchat_room['nomTchat_room'].'</h4>
                            </div>
                            <div id="divtest" class="clearfix"></div>
                        </div>
                        <div  id="chat" class="panel-collapse collapse in">
    <div id="divMessage" class="portlet-body chat-widget" style="overflow-y: auto; width: auto; height: 300px;">
                            </div>
                           <div class="portlet-footer">
                                <form role="form">
                                    <div class="form-group">
                                        <textarea style="resize:none;" id="Message" class="form-control" placeholder="Enter message..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button onclick="sendMessage(' . $tchat_room['idTchat_room'] .')" type="button" class="btn btn-default pull-right">Send</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: inline-block;">
                    <h2>Echéance de la salle</h2>
                <p>'.$tchat_room['dureeVieTchat_room'].'</p>
                <h2>Descritpion</h2>
                <p style="width: 200px;">'.$tchat_room['descritpionTchat_room'].'</p><br>';
    if (!verifAdmin()) {
        $return .= '<a href="leaveRoomTchat.php?idTchat_room=' . $tchat_room['idTchat_room'] . '" class="btn btn-danger">Quitter la salle de tchat</a>';
    }
 else {
        $return .= '<a href="javascript:deleteTchatRoom('.$tchat_room['idTchat_room'].', true)" class="btn btn-danger">Supprimer la salle</a>';
    }           
                $return.= '</div>
            </div>
        </div>';
    }
    return $return;
}

function listTchatRoom(){
    return '<div class="container">
            <h1 style="display: inline">Les salles de tchat :</h1>
            <input style="display: inline-block;width: 75%" type="text" class="form-control" id="rechercheTchatRoom" placeholder="Rechercher le nom de la salle">
            <input style="display: inline-block;width: 25%" type="button" value="Rechercher" class="btn btn-primary pull-right" onclick="searchTchatRoom()">
            <table class="table table-bordered">
                <tr>
                    <th>logo</th>
                    <th>Nom de la salle</th>
                    <th>Descritpion</th>
                    <th>Date d\'échéance</th>
                    <th>Supprimer</th>
                </tr>
                <tbody id="resultTchat" style="text-align: center;">

                    </tbody>
                </table>
            </div>';
}

/**
 * 
 * @return string
 */
function participeTchat() {
    $return = "";
    foreach (readTchat_roomByUserId($_SESSION['idUtilisateurConnecte']) as $tchatRoom) {
        $return .= '<tr>
                         <td><img width="50" height="50" src="img/vignette/' . $tchatRoom['vignetteTchat_room'] . '"></td>
                         <td><a href="roomTchat.php?idTchat_room=' . $tchatRoom['idTchat_room'] . '">' . $tchatRoom['nomTchat_room'] .'</a></td>
                         <td>' . $tchatRoom['descritpionTchat_room'] . '</td>
                         <td>' . $tchatRoom['dureeVieTchat_room'] . '</td>
                        </tr>';
    }
    return $return;
}

function noParticipeTchat() {
    $return = "";
    foreach (readNoTchat_roomByUserId($_SESSION['idUtilisateurConnecte']) as $tchatRoom) {
        $return .= '<tr>
                         <td><img width="50" height="50" src="img/vignette/' . $tchatRoom['vignetteTchat_room'] . '"></td>
                         <td>' . $tchatRoom['nomTchat_room'] . '</td>
                         <td>' . $tchatRoom['descritpionTchat_room'] . '</td>
                         <td>' . $tchatRoom['dureeVieTchat_room'] . '</td>
                             <td><a class="btn btn-primary" href="joinRoomTchat.php?idTchat_room=' . $tchatRoom['idTchat_room'] . '">Rejoindre</a></td>
                        </tr>';
    }
    return $return;
}

function membresAffichageUser() {
    return '<div class="container">
            <div class="tableauxUsers">
                <h1>Membres non ami(e)s</h1>
                <input style="display: inline-block;width: 75%" type="text" class="form-control" id="rechercheNonAmis" placeholder="Rechercher le pseudo">
                <input style="display: inline-block;width: 25%" type="button" value="Rechercher" class="btn btn-primary pull-right" onclick="searchNoFriend()">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Pseudo</th>
                            <th>Inviter</th>
                        </tr>
                    </thead>
                    <tbody id="resultNonAmis" style="text-align: center;">

                    </tbody>
                </table>
            </div>
            <div class="tableauxUsers" style="float: right;">
                <h1 style="float: right">Mes ami(e)s</h1>
                <input style="display: inline-block;width: 75%" type="text" class="form-control" id="rechercheAmis" placeholder="Rechercher le pseudo">
                <input style="display: inline-block;width: 25%" type="button" value="Rechercher" class="btn btn-primary pull-right" onclick="searchFriend()">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Pseudo</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody id="resultAmis" style="text-align: center">

                    </tbody>
                </table>
            </div>
        </div>';
}
function membresAffichageAdmin() {
    return '<div class="container">
                <h1>Les membres</h1>
                <input style="display: inline-block;width: 75%" type="text" class="form-control" id="rechercheUser" placeholder="Rechercher le pseudo">
                <input style="display: inline-block;width: 25%" type="button" value="Rechercher" class="btn btn-primary pull-right" onclick="searchUser()">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Pseudo</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Supprimer l\'utilisateur</th>
                        </tr>
                    </thead>
                    <tbody id="resultUser" style="text-align: center;">

                    </tbody>
                </table>
        </div>';
}

function footer() {
    return '<footer class="footer">
      <div class="container" style="text-align:center;">
        <p style="display:inline-block;float:left;" class="text-muted">Pierrick Antenen ©</p>
        <p style="display:inline-block;" class="text-muted">CFPT TPI</p>
        <p style="display:inline-block;float:right" class="text-muted">Juin 2017</p>
      </div>
    </footer>';
}
