
const tbody = document.getElementById('tbody');
const cmbEtat = document.getElementById('etat');
const cmbGuichet = document.getElementById('guichet');
const today = new Date();
const start = document.getElementById('start');
const end = document.getElementById('end');
var tab =[];
cmbGuichet.addEventListener('change',updateTab);
cmbEtat.addEventListener('change',updateTab);
start.addEventListener('change',updateTab);
end.addEventListener('change',updateTab);
a=false;
function addRow(array) 
{
    while (tbody.firstChild) 
    {
        tbody.removeChild(tbody.firstChild);
    }
    if (!a) 
    {
        addGuichet();
    }
    for (let index = 0; index < array.length; index++) 
    {
        let tr = document.createElement('tr');
        tr.id=array[index].id;
        let arr=createRowElement(array[index]);
        arr.forEach((value) => tr.appendChild(value));
        tbody.appendChild(tr);
    }
    a=true;
}

function createRowElement(commande)
{
    let array=[];
    
    let classe = document.createElement('td');
    let classeContent = document.createTextNode(commande.classe);
    classe.appendChild(classeContent);
    array.push(classe);

    let trajet = document.createElement('td');
    let trajetContent = document.createTextNode(`${commande.depart}-${commande.arrivee}`);
    trajet.style.width="150px";
    trajet.appendChild(trajetContent);
    array.push(trajet);

    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(commande.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);

    let NbreCom = document.createElement('td');
    NbreCom.style.width="100px";
    let NbreComContent = document.createTextNode(commande.nombreDeBilletCommander);
    NbreCom.appendChild(NbreComContent);
    array.push(NbreCom);

    let NbreReal = document.createElement('td');
    NbreReal.style.width="100px";
    let NbreRealContent = document.createTextNode(commande.nombreBilletRealiser);
    NbreReal.appendChild(NbreRealContent);
    array.push(NbreReal);

    let realisation = document.createElement('td');
    
    let pdiv =document.getElementById('pdiv').cloneNode(true);
    pdiv.style.display='block';
    
    let pdiv2 =document.getElementById('pdiv2').cloneNode(true);
    pdiv2.style.display = 'block';
    let progress =(commande.nombreBilletRealiser
    /commande.nombreDeBilletCommander)*100;
    pdiv2.style.width = `${progress}%`
    let realisationContent = document.createTextNode(`${progress.toFixed(2)}%`);
    pdiv2.appendChild(realisationContent);
    pdiv.appendChild(pdiv2)
    realisation.appendChild(pdiv);
    array.push(realisation);
   
    
    
    

    let DateCommande = document.createElement('td');
    DateCommande.style.width="180px";
    var d = new Date(commande.dateCommande.date);
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    //let DateCommandeContent = document.createTextNode(`${d.toDateString()}`);
    let DateCommandeContent = document.createTextNode(`${d.toLocaleDateString('fr-FR', options)}`);
    DateCommande.appendChild(DateCommandeContent);
    array.push(DateCommande);

    let button = document.createElement('button');
    let buttonContent = document.createTextNode('Valider');
    button.appendChild(buttonContent);
    button.id = ""+commande.id;
    button.type = "button";
    button.disabled = false;
    button.classList.add('btn');
    if(commande.etat===1)
    {
        button.classList.add('btn-success');
        button.classList.remove('btn-danger');
        button.innerText="validé";
    }
    else if(commande.etat===0)
    {
        button.classList.add('btn-danger');
        button.innerText="Non Validé";
        button.classList.remove('btn-success');
    }
    else if(commande.etat===2)
    {
        button.classList.add('btn-warning');
        button.innerText="en cours traitement";
        button.classList.remove('btn-success');
    }
    else if(commande.etat===3)
    {
        button.classList.add('btn-info');
        button.innerText="traité";
        button.classList.remove('btn-success');
    }
    array.push(button);

    
    

    return array;
}
function DateCompare(date1,date2)
{
    let a=true;
    if(date1.getDate() != date2.getDate())
    {
        return false;
    }
    else if(date1.getMonth() != date2.getMonth())
    {
        return false
    }
    else if(date1.getFullYear() != date2.getFullYear())
    {
        return false;
    }
    return true;
}

function addGuichet()
{
    for (let index = 1; index < cmbGuichet.children.length; index++) 
    {
        cmbGuichet.removeChild(cmbGuichet.children[index]);
    }
    let xhr=new XMLHttpRequest();
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            
            let tabgui = JSON.parse(this.responseText); 
            for (let index = 0; index < tabgui.length; index++) 
            {
                let option = document.createElement('option');
                let optionContent = document.createTextNode(tabgui[index].nom);
                option.appendChild(optionContent);
                cmbGuichet.appendChild(option);
            }
            
        }
    }
    xhr.open("GET","http://localhost:8000/json/guichet/",true);
    xhr.send();
    
}
function getAllCommande()
{
    let xhr=new XMLHttpRequest();
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            console.log(JSON.parse(this.responseText));
            addRow(JSON.parse(this.responseText));
            tab = JSON.parse(this.responseText); 
        }
    }
    xhr.open("GET","http://localhost:8000/Json/listCommandeNavette",true);
    xhr.send();

}
function updateTab()
{
  let guichetSelected = cmbGuichet.selectedIndex;
  let etatSelected = cmbEtat.selectedIndex;
  let tab1 = tab;
  if(guichetSelected ==0 && start.value == '' && end.value == '' && etatSelected ==0)
  {
    getAllCommande();
  }
  if(guichetSelected !=0)
  {
        tab1 = tab1.filter((value)=>
        {
            alert(cmbGuichet.options[cmbGuichet.selectedIndex].value);
            return cmbGuichet.options[cmbGuichet.selectedIndex].value ==value.guichet;
        })
  }
  if(etatSelected !==0)
  {
        
       // alert(etatSelected);
        tab1 = tab1.filter((value)=>
        {
            
            let sss=etatSelected - 1;
            //alert(sss+":::::"+value.etat);
            if (sss == value.etat)
            {
                return true  ;    
            }
            else
            {
                //alert("ssss");
                return false  ;
            }
            
        })
  }
  if(start.value != '' && end.value != '')
  {
    let dstart = new Date(start.value);
    let dend = new Date(end.value);
    tab1 = tab1.filter((value)=>
    {
        var date = new Date(value.dateCommande.date);
        if(DateCompare(date,dstart))
        {
            console.log("true");
            return true;
        }
        else if(DateCompare(date,dend))
        {
            console.log("true");
            return true;
        }
        else if(date > dstart && date < dend)
        {
            console.log("true");
            return true;
        }
        else
        {
            console.log("false");
            return false;
        }
            
    })

  }
  
  addRow(tab1);

}
getAllCommande();