$(document).ready(function () {
    $('#selUser, #selCommande, #selImpression').select2({theme: "bootstrap"});

    //AJAX remplir tableau
    // $.ajax({
    //     url: '/destinateur/find/all/user',
    //     type: 'post',
    //     data: {},
    //     dataType: 'json',
    //     success: function (data) {
    //         switch(data.status) {
    //             case 'error':
    //                 swal("Erreur", data.message, "error");
    //                 break;
    //             case 'success':
    //                 console.log(data);
    //                 console.log(data.utilisateur[0]);
    //                 break;
    //             default:
    //                 swal("Errer", data.message, "error");
    //         }
    //     },
    //     error: function (error) {
    //         alert('Erreur '+error);
    //     }
    // });
    // return false;
    //AJAX est fini

    $('.form').on('submit', function (e) {
        e.preventDefault();
        alert('ok');
        var user = $('#selUser').val();
        var command = $('#selCommande').val();
        var impression = $('#selImpression').val();
        alert(user);
        alert(command);
        alert(impression);

        //AJAX
        // $.ajax({
        //     url: $(this).attr('action'),
        //     type: $(this).attr('method'),
        //     data: $(this).serialize(),
        //     dataType: 'json',
        //     success: function (data) {
        //         switch(data.status) {
        //             case 'error':
        //                 swal("Erreur", data.message, "error");
        //                 break;
        //             case 'success':
        //                 swal("SUCCES", data.message, "success");
        //                 break;
        //             default:
        //                 swal("Errer", data.message, "error");
        //         }
        //     },
        //     error: function (error) {
        //         alert('Erreur '+error);
        //     }
        // });
        // return false;
        //END AJAX


    });

});