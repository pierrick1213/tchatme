<?php

session_start();
require_once 'dao.php';

function navBar() {
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
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Mes salles de tchat</a></li>
                        <li><a href="#">Autres salles disponibles</a></li>
                        <li><a href="users.php">Les membres</a></li>              
                    </ul>
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
                                <td style="padding: 0;border: 1px solid white;"><img onclick="acceptInvit('.$invit['idUtilisateur'].')" width="10" height="10" src="img/icon/checked.svg"></td>
                                <td style="padding: 0;border: 1px solid white;"><img onclick="refuseInvit('.$invit['idUtilisateur'].')" width="10" height="10" src="img/icon/cancel.svg"></td>
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
        header("location: login.php");
    }
}

function verifIdUser() {
    if (isset($_GET['idUtilisateur'])) {
        if ($_GET['idUtilisateur'] == $_SESSION['idUtilisateurConnecte']) {
            header("location: profil.php");
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
            if (readIfUserIsFriendOrNot($_SESSION['idUtilisateurConnecte'], $idUtilisateur) === 0) {
                $return .='<a href="javascript:deleteFriend(' . $_GET['idUtilisateur'] . ', true)" class="btn btn-danger">Supprimer de mes amis</a>';
            } else if (readIfUserIsFriendOrNot($_SESSION['idUtilisateurConnecte'], $idUtilisateur) === 2) {
                $return .='<a href="javascript:sendInvitText(' . $_GET['idUtilisateur'] . ', true)" class="btn btn-primary">Ajouter en tant qu\'ami</a>';
            } else if (readIfUserIsFriendOrNot($_SESSION['idUtilisateurConnecte'], $idUtilisateur) === 1) {
                $return .= 'En attente de l\'acceptation de la demande';
            }
        } else {
            $return .= '<a href="" class="btn btn-success">Modifier Profil</a>';
        }
        $return .='</div>';
    }
    return $return;
}

function newTchatRoom(){
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
                        <input name="date" type="date" class="form-control" id="inputDateOfTchatRoom" required>';

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
                    <div class="col-sm-8" style="width: 100%;">
                        <input name="submit" style="width: 50%; margin: auto;" type="submit" class="form-control" id="submit">
                    </div>
                </div>
            </form>
        </div>';
                    
                    return $return;
}

function tchatRoom() {
    return '<div class="container bootstrap snippet">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="portlet portlet-default">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h4><i class="fa fa-circle text-green"></i> Jane Smith</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="chat" class="panel-collapse collapse in">
                            <div class="portlet-body chat-widget" style="overflow-y: auto; width: auto; height: 300px;">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="text-center text-muted small">January 1, 2014 at 12:23 PM</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object img-circle" src="http://lorempixel.com/30/30/people/1/" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">Jane Smith
                                                    <span class="small pull-right">12:23 PM</span>
                                                </h4>
                                                <p>Hi, I wanted to make sure you got the latest product report. Did Roddy get it to you?</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object img-circle" src="http://lorempixel.com/30/30/people/7/" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">John Smith
                                                    <span class="small pull-right">12:28 PM</span>
                                                </h4>
                                                <p>Yeah I did. Everything looks good.</p>
                                                <p>Did you have an update on purchase order #302?</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object img-circle" src="http://lorempixel.com/30/30/people/7/" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">Jane Smith
                                                    <span class="small pull-right">12:39 PM</span>
                                                </h4>
                                                <p>No not yet, the transaction hasnt cleared yet. I will let you know as soon as everything goes through. Any idea where you want to get lunch today?</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <div class="portlet-footer">
                                <form role="form">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Enter message..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default pull-right">Send</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
}

function participeTchat() {
    $return = "";
    foreach (readTchat_roomByUserId($_SESSION['idUtilisateurConnecte']) as $tchatRoom) {
        $return .= '<tr>
                         <td><img width="50" height="50" src="img/vignette/' . $tchatRoom['vignetteTchat_room'] . '"></td>
                         <td><a href="roomTchat.php?idTchat_room=' . $tchatRoom['idTchat_room'] . '">' . $tchatRoom['nomTchat_room'] . '</a></td>
                         <td>' . $tchatRoom['descritpionTchat_room'] . '</td>
                         <td>' . $tchatRoom['dureeVieTchat_room'] . '</td>
                        </tr>';
    }
    return $return;
}

function membresAffichage() {
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

function footer() {
    return '<footer class="footer">
      <div class="container" style="text-align:center;">
        <p style="display:inline-block;float:left;" class="text-muted">Pierrick Antenen ©</p>
        <p style="display:inline-block;" class="text-muted">CFPT TPI</p>
        <p style="display:inline-block;float:right" class="text-muted">Juin 2017</p>
      </div>
    </footer>';
}
