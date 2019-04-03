$(document).ready(function () {
    $('#selUser, #selCommande, #selImpression').select2({theme: "bootstrap"});

    function checkVal(val) {
        if(val) {
            return true;
        }
        return false;
    }

    $('#table').DataTable({
        "reponsive": true,
        "pageLength": 10,
        "language": {
            "decimal": "",
            "loadingRecords": "Chargement...",
            "processing": "En traitement...",
            "lengthMenu": "Afficher _MENU_ entrées",
            "zeroRecords": "Aucun enregistrements correspondants trouvés",
            "emptyTable": "aucune donnée disponible",
            "infoFiltered": "(filtré de _MAX_ entrées totales)",
            "infoEmpty": "Affiche 0 à 0 sur 0 entrées",
            "info": "Affiche _START_ à _END_ sur _TOTAL_ entrées",
            "search": "Rechercher : ",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "previous": "Précédent",
                "next": "Suivant"
            }
        }
    });

    $('.form').on('submit', function (e) {
        e.preventDefault();
        var user = $('#selUser').val();
        var commande = $('#selCommande').val();
        var impression = $('#selImpression').val();
        datas = [];

        if(!checkVal(commande) && !checkVal(commande) && !checkVal(impression)) {
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

        if(checkVal(user))
            datas.push(user);
        if(checkVal(commande))
            datas.

    });

});