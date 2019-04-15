const   inputs = document.getElementsByTagName('input');
const tbody = document.getElementById('tbody');
function addRow(array) 
{
    while (tbody.firstChild) 
    {
        tbody.removeChild(tbody.firstChild);
    }
    for (let index = 0; index < array.length; index++) 
    {
        let tr = document.createElement('tr');
        tr.id=array[index].id;
        let arr=createRowElement(array[index]);
        arr.forEach((value) => tr.appendChild(value));
        tbody.appendChild(tr);
    }
}

function createRowElement(commande)
{
    let array=[];
    
    let prix = document.createElement('td');
    let prixContent = document.createTextNode(commande.Prix);
    prix.appendChild(prixContent);
    array.push(prix);

    let guichet = document.createElement('td');
    let guichetContent =document.createTextNode('Controlleur') ;
    guichet.appendChild(guichetContent);
    array.push(guichet);

    
    let nombreCommande = document.createElement('td');
    let div= document.createElement('div');
    div.classList.add('form-group');
    
    let input= document.createElement('input');
    input.type = 'number';
    input.classList.add('form-control');
    input.id=''+commande.id;
    input.placeholder = 'nombre de billet';
    div.appendChild(input);
    nombreCommande.appendChild(div);
    array.push(nombreCommande);

      
    let button = document.createElement('button');
    let buttonContent = document.createTextNode('Valider');
    button.appendChild(buttonContent);
    button.id = "b"+commande.id;
    button.type = "button";
    button.disabled = false;
    button.style.display = 'none';
    button.classList.add('btn');

    array.push(button);
    return array;
}

function controlPasserCommande()
 {
    swal({
        title: "Etes vous sûr ?",
        text: "souhaitez-vous passer ces commandes",
        icon: "warning",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                passerCommande();
            }
        });
 }
 function afterCommande()
 {
    swal({
        title: "commande envoyé",
        text: "verifier si tous vos commande ont bien été envoyé",
        icon: "success",
        
    })
        .then((value) => {
            document.location.href="http://serveurptb:8000/commande/taxe";
            
        });
 }
 function passerCommande() 
 {
    
    
    for (let i = 0; i < inputs.length; i++) 
    {
        let xhttp=new XMLHttpRequest();
        let button=document.getElementById('b'+inputs[i].id)
        xhttp.onload = function ()
        {
            if(this.status==200)
            {
                console.log(this.responseText);
                button.classList.add('btn-success');
                button.classList.remove('btn-danger');
                button.innerText="validé";
                button.style.display='block';
            }
            else
            {
                button.classList.add('btn-danger');
                button.classList.remove('btn-success');
                button.innerText="echec";
                button.style.display='block';
            }
        }
        let link ="http://serveurptb:8000/newCommandeTaxe/";
        let params =`${inputs[i].value}`;

        if (parseInt(params,10)>0 ) 
        {
            xhttp.open("POST",link,true);
            xhttp.send(params);  
        }
        else
        {
            alert ('error');
        }
            

    } 
    
        afterCommande();
 }
 function getTaxes() 
 {
        let xhttp=new XMLHttpRequest();
        xhttp.onload = function ()
        {
            addRow(JSON.parse(this.responseText));
            console.log(JSON.parse(this.responseText))
        }
        let link ="http://serveurptb:8000/json/BilletsTaxe/";
        
        
        xhttp.open("GET",link,true);
        xhttp.send();  
        
     
    
     
 }
 getTaxes();
 
          