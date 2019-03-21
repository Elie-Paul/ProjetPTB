// document.getElementById("plusieurs").addEventListener('click', function () {
//     alert('hhhhh');
//     if (this.checked) {
//         document.getElementById('block').style.display = 'block';
//     } else {
//         document.getElementById('block').style.display = 'none';
//     }
// });

function ajouter(abonnement) {

}

document.getElementById("plusieurs").addEventListener('click', function (e) {
    e.preventDefault();
    alert('moi');
    var elemts = document.getElementById('block');
    elemts.style.display = 'block';
    return true;

});


document.querySelector('#monBouton').addEventListener('click', function (e) {
    // e.preventDefault();
    // alert('salut thera');
    let choix;
    let les_champs = document.querySelectorAll('.champs');
    for (let i = 0; i < les_champs.length; i++) {
        if (les_champs[i].checked) {
            choix = choix + les_champs[i].value + ',';
            alert('La case cochée est la n°' + les_champs[i].value);
        }
    }
    let choixsplitted = choix.split(',');
    return true;

});