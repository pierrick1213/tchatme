function searchNoFriend() {
    var nameNoFriend = $('#rechercheNonAmis').val();
    $.ajax({
        type: 'POST',
        url: 'searchAjaxNoFriend.php',
        data: {'nameNoFriend': nameNoFriend},
        dataType: 'html',
        success: function (data) {
            $('#resultNonAmis').html(data);
        },
        error: function (jqXHR) {
            $('#resultNonAmis').html(jqXHR.toString());
        }
    });
}

function searchFriend() {
    var nameFriend = $('#rechercheAmis').val();
    $.ajax({
        type: 'POST',
        url: 'searchAjaxFriend.php',
        data: {'nameFriend': nameFriend},
        dataType: 'html',
        success: function (data) {
            $('#resultAmis').html(data);
        },
        error: function (jqXHR) {
            $('#resultAmis').html(jqXHR.toString());
        }
    });
}

function searchUser(){
    var nameUser = $('#rechercheUser').val();
    $.ajax({
        type: 'POST',
        url: 'searchUserAjax.php',
        data: {'nameUser': nameUser},
        dataType: 'html',
        success: function (data) {
            $('#resultUser').html(data);
        },
        error: function (jqXHR) {
            $('#resultUser').html(jqXHR.toString());
        }
    });
}

function searchTchatRoom(){
    var nameTchatRoom = $('#rechercheTchatRoom').val();
    $.ajax({
        type: 'POST',
        url: 'searchRoomTchatAjax.php',
        data: {'nameTchatRoom': nameTchatRoom},
        dataType: 'html',
        success: function (data) {
            $('#resultTchat').html(data);
        },
        error: function (jqXHR) {
            $('#resultTchat').html(jqXHR.toString());
        }
    });
}

function sendInvitText(idUtilisateur, profil) {

    var texteDemande = prompt("Veuillez indiquer la raison de votre demande d'amitié (laissez vide si aucune raison)");
    if (texteDemande !== null) {
        $.ajax({
            type: 'POST',
            url: 'sendInvitAjax.php',
            data: {'idUtilisateur': idUtilisateur, 'texteDemande': texteDemande},
            success: function () {
                if (profil === true) {
                    document.location.href = "profil.php?idUtilisateur=" + idUtilisateur;
                } else {
                    searchNoFriend();
                }
            },
            error: function (jqXHR) {

            }
        });
    }
}

function deleteFriend(idUtilisateur, profil) {
    $.ajax({
        type: 'POST',
        url: 'deleteFriendAjax.php',
        data: {'idUtilisateur': idUtilisateur},
        success: function () {
            if (profil) {
                document.location.href = "profil.php?idUtilisateur=" + idUtilisateur;
            }
            else {
                searchFriend();
                searchNoFriend();
            }

        },
        error: function (jqXHR) {

        }
    });
}
function deleteUser(idUtilisateur, profil){
    $.ajax({
        type: 'POST',
        url: 'deleteUserAjax.php',
        data: {'idUtilisateur': idUtilisateur},
        success: function () {
            if (profil) {
                document.location.href="users.php" 
            }
            else{
                searchUser();
            }
        },
        error: function (jqXHR) {

        }
    });
}

function deleteTchatRoom(idTchatRoom, tchatRoom){
    $.ajax({
        type: 'POST',
        url: 'deleteTchatRoomAjax.php',
        data: {'idTchatRoom': idTchatRoom},
        success: function () {
            if (tchatRoom) {
                document.location.href="roomTchatAdmin.php" 
            }
            else{
                searchTchatRoom();
            }
                
        },
        error: function (jqXHR) {

        }
    });
}

function acceptInvit(idUtilisateur){
    $.ajax({
        type: 'POST',
        url: 'acceptInvitAjax.php',
        data: {'idUtilisateur': idUtilisateur},
        success: function () {
            window.location.reload();
        },
        error: function (jqXHR) {

        }
    });
}

function refuseInvit(idUtilisateur){
    $.ajax({
        type: 'POST',
        url: 'refuseInvitAjax.php',
        data: {'idUtilisateur': idUtilisateur},
        success: function () {
            window.location.reload();
        },
        error: function (jqXHR) {

        }
    });
}

function readMessage(idTchatRoom, down){
    $.ajax({
        type: 'POST',
        url: 'readMessageAjax.php',
        data: {'idTchatRoom': idTchatRoom},
        dataType: 'html',
        success: function (data) {
            $('#divMessage').html(data);
            if (down === true) {
            window.location.hash = '';
            window.location.hash = '#down';
            }
            
        },
        error: function (jqXHR) {
            $('#divMessage').html(jqXHR.toString());
        }
    });
}

function sendMessage(idTchatRoom){
     var message = $("#Message").val();
     if (message !== "") {
     $.ajax({
        type: 'POST',
        url: 'sendMessageAjax.php',
        data: {'idTchatRoom': idTchatRoom, 'message': message},
        success: function () {
            readMessage(idTchatRoom, true);
            $("#Message").val("");
        },
        error: function (jqXHR) {

        }
    });
    }
     
}


