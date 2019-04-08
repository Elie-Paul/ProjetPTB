$(document).ready(function () {
    $('#selUser, #selCommande, #selImpression').select2({theme: "bootstrap"});


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

});