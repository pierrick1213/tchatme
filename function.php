<?php
session_start();
require_once 'dao.php';

function navBar() {
    foreach (readUserById($_SESSION['idUtilisateurConnecte']) as $user) {

        return '<div class="navbar navbar-default navbar-fixed-top" role="navigation">
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
                                <strong>'.$user["prenomUtilisateur"].'</strong>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center">
                                                    <!--<span class="glyphicon glyphicon-user icon-size"></span>-->
                                                    <img width="100" height="100" src="img/avatar/'.$user["avatarUtilisateur"].'" alt="">
                                                </p>
                                            </div>
                                            <div class="col-lg-8">
                                                <p class="text-left"><strong>'.$user["prenomUtilisateur"].' '.$user["nomUtilisateur"].'</strong></p>
                                                <p class="text-left small">'.$user["emailUtilisateur"].'</p>
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
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div><br><br>';
    }
}

function verifConnecte() {
    if (!isset($_SESSION['idUtilisateurConnecte'])) {
        header("location: login.php");
    }
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
                         <td><img width="50" height="50" src="img/vignette/'.$tchatRoom['vignetteTchat_room'].'"></td>
                         <td><a href="roomTchat.php?idTchat_room=' . $tchatRoom['idTchat_room'] . '">' . $tchatRoom['nomTchat_room'] . '</a></td>
                         <td>' . $tchatRoom['descritpionTchat_room'] . '</td>
                         <td>' . $tchatRoom['dureeVieTchat_room'] . '</td>
                        </tr>';
    }
    return $return;
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
