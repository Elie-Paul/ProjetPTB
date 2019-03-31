$(document).ready(function () {


    $('.foSection').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                switch(data.status) {
                    case 'error':
                        swal("Erreur", data.message, "error");
                        break;
                    case 'success':
                        swal("SUCCES", data.message, "success");
                        break;
                    default:
                        swal("Error", data.message, "error");
                }
            },
            error: function (error) {
                alert('Erreur '+error);
            }
        });
        return false;
    });

    $('.foTrajet').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                switch(data.status) {
                    case 'error':
                        console.log(data);
                        swal("Erreur", data.message, "error");
                        break;
                    case 'success':
                        swal("SUCCES", data.message, "success");
                        break;
                    default:
                        swal("Error", data.message, "error");
                }
            },
            error: function (error) {
                alert('Erreur '+error);
            }
        });
        return false;
    });


    $('#btnSection').on('click', function (e) {
        e.preventDefault();
        var $formSection = $('#section');
        if ($formSection.css('display') === ('none')) {

            $formSection.slideToggle(1000);
        } else {

            $formSection.slideToggle(1000);
        }
    });
    $('#btnTrajet').on('click', function (e) {
        e.preventDefault();
        var $formTrajet = $('#trajet');
        if ($formTrajet.css('display') === ('none')) {

            $formTrajet.slideToggle(1000);
        } else {

            $formTrajet.slideToggle(1000);
        }
    });
    $('#btnAddBilletEvent').on('click', function (e) {
        e.preventDefault();
        console.log('Bonjour');
        var $formBillet = $('#billet');
        if ($formBillet.css('display') === ('none')) {

            $formBillet.slideToggle(1000);
        } else {

            $formBillet.slideToggle(1000);
        }
    })
});