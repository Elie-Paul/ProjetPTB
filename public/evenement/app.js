$(document).ready(function () {
    $('#btnSection').on('click', function (e) {
        e.preventDefault();
        var $formSection = $('#section');
        if ($formSection.css('display') === ('none')) {

            $formSection.slideDown(1000);
        }
        else {

            $formSection.slideUp(1000);
        }
    });
    $('#btnTrajet').on('click', function (e) {
        e.preventDefault();
        var $formTrajet = $('#trajet');
        if ($formTrajet.css('display') === ('none')) {

            $formTrajet.fadeIn(1000);
        }
        else {

            $formTrajet.fadeOut(1000);
        }
    });
    $('#btnAddBilletEvent').on('click', function (e) {
        e.preventDefault();
        console.log('Bonjour');
        var $formBillet = $('#billet');
        if ($formBillet.css('display') === ('none')) {

            $formBillet.slideToggle(1000);
        }
        else {

            $formBillet.fadeOut(1000);
        }
    })
});