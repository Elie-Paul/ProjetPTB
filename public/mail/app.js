$(document).ready(function () {
    $('#selUser, #selCommande, #selImpression').select2({theme: "bootstrap"});
    $('#select').select2({
        theme: "classic",
        placeholder: "Emails",
        allowClear: true
    });


    $('.form').on('submit', function (e) {
        e.preventDefault();
        var user = $('#selUser').val();
        var commande = $('#selCommande').val();
        var impression = $('#selImpression').val();
        // datas = [];

        if(user || commande || impression) {
            //AJAX
            $.ajax({
                url: '/destinateur/add/mail',
                type: 'post',
                data: {user: user, commande: commande, impression: impression},
                dataType: 'json',
                success: function (data) {
                    switch (data.status) {
                        case 'error':
                            swal("Erreur", data.message, "error");
                            break;
                        case 'success':
                            console.log(data.message);
                            swal("SUCCES", data.message, "success");
                            $('.table').load('http://localhost:8000/destinateur .table');
                            break;
                        default:
                            swal("Erreur", data.message, "error");
                    }
                },
                error: function (error) {
                    alert('Erreur ' + error);
                }
            });
            return false;
            //END AJAX
        }

    });

    //ENVOI DE MAIL DANS LE DASHBOARD
    $('.envoiMesMails').on('submit', function (e) {
        e.preventDefault();
        if(!navigator.onLine) {
            swal("ERREUR", "Désolé, Vous n'êtes pas connecté à l'internet", "error");
            return false;
        }
        var mails = $('#select').val();
        var objet = $('#objet').val();
        var message = $('#message').val();
        //L'EMAIL DU DESTINATEUR EST CACHE AVEC CSS IL SE TROUVE JUSTE AVANT FORM QUI ENVOI LE MAIL DEPUIS LE DASHBOARD
        var emetteur = $('#emailExpediteur').text();

        if(mails && objet && message) {
            //AJAX
            $.ajax({
                url: '/mail/presonnel',
                type: 'post',
                data: {mails: mails, objet: objet, message: message, emetteur: emetteur},
                dataType: 'json',
                success: function (data) {
                    switch (data.status) {
                        case 'error':
                            swal("Erreur", data.message, "error");
                            break;
                        case 'success':
                            swal("SUCCES", data.message, "success");
                            break;
                        default:
                            swal("Erreur", data.message, "error");
                    }
                },
                error: function (error) {
                    alert('Erreur ' + error);
                }
            });
            return false;
            //END AJAX
        }
        else {
            swal("ERREUR", 'Tous les champs sont obligatoires pour envoyer un email', "error");
        }

    });
});