const tbody = document.getElementById('tbody');
const cmbGuichet = document.getElementById('guichet');
const today = new Date();
const start = document.getElementById('start');
const end = document.getElementById('end');
var tab =[];
cmbGuichet.addEventListener('change',updateTab);
start.addEventListener('change',updateTab);
end.addEventListener('change',updateTab);
a=false;
function addRow(array) 
{
    while (tbody.firstChild) 
    {
        tbody.removeChild(tbody.firstChild);
    }
    for (let index = 0; index < array.length; index++) 
    {
        if(array[index].etat==0)
        {
            let tr = document.createElement('tr');
            tr.id=array[index].id;
            let arr=createRowElement(array[index]);
            arr.forEach((value) => tr.appendChild(value));
            tbody.appendChild(tr);
        }
        
    }
    if(!a)
        addGuichet();
    a=true;
}

function createRowElement(commande)
{
    let array=[];
    
    let type = document.createElement('td');
    let typeContent = document.createTextNode(commande.type);
    type.appendChild(typeContent);
    array.push(type);

    let section = document.createElement('td');
    let sectionContent = document.createTextNode(commande.section);
    section.appendChild(sectionContent);
    array.push(section);
    
    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(commande.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);

    let NbreCom = document.createElement('td');
    let NbreComContent = document.createTextNode(commande.nombreDeBilletCommander);
    NbreCom.appendChild(NbreComContent);
    array.push(NbreCom);

    

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
    button.classList.add('btn');
    button.classList.add('btn-success');
    button.innerText="valider";
    
    
    button.addEventListener('click',(e) => validationAction(e.target));
    array.push(button);
    return array;
}
function validationAction(button)
{
    let xhr=new XMLHttpRequest();
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            //console.log(JSON.parse(this.responseText));
            //addRow(JSON.parse(this.responseText));
           console.log(this.responseText);
        }
    }
    xhr.open("POST","http://localhost:8000/ValidationCommandeVignette",true);
    xhr.send(button.id);
    getAllCommande();
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
    xhr.open("GET","http://localhost:8000/Json/listCommandeVignette",true);
    xhr.send();

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

function updateTab()
{
  let guichetSelected = cmbGuichet.selectedIndex;
  let tab1 = tab;
  if(guichetSelected ==0 && start.value == '' && end.value == '' )
  {
    getAllCommande();
  }
  if(guichetSelected !=0)
  {
        tab1 = tab1.filter((value)=>
        {
            return cmbGuichet.options[cmbGuichet.selectedIndex].value ==value.guichet;
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