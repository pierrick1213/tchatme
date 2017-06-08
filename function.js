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
            if (profil === true) {
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


