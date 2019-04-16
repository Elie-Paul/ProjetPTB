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

    $("table").tableExport().remove();
          
    $("table").tableExport({
        headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
        footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
        formats: ["xls", "csv", "txt"],    // (String[]), filetypes for the export
        fileName: "idghg",                    // (id, String), filename for the downloaded file
        bootstrap: true,                   // (Boolean), style buttons using bootstrap
        position: "top",               // (top, bottom), position of the caption element relative to table
        ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file(s)
        ignoreCols: [7,7],                  // (Number, Number[]), column indices to exclude from the exported file(s)
        ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
        emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
        trimWhitespace: false              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
    });
}

function createRowElement(commande)
{
    let array=[];
    
    let prix = document.createElement('td');
    let prixContent = document.createTextNode(commande.prix);
    prix.appendChild(prixContent);
    array.push(prix);

    let guichet = document.createElement('td');
    let guichetContent =document.createTextNode(commande.guichet) ;
    guichet.appendChild(guichetContent);
    array.push(guichet);

    let nombreCommande = document.createElement('td');
    let div= document.createElement('div');
    div.classList.add('form-group');
    
    let NbreCom = document.createElement('td');
    NbreCom.style.width="100px";
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
    button.classList.remove('btn-danger');
    button.innerText="valider";
    button.addEventListener('click',(e) => validationAction(e.target));
    array.push(button);

    return array;
}
function getTaxes() 
 {
        let xhttp=new XMLHttpRequest();
        xhttp.onload = function ()
        {
            addRow(JSON.parse(this.responseText));
            console.log(JSON.parse(this.responseText))
            tab = JSON.parse(this.responseText);
        }
        let link ="http://serveurptb:8000/Json/listCommandeTaxe";
        
        
        xhttp.open("GET",link,true);
        xhttp.send();  
        
     
    
     
 }
 function validationAction(button)
{
    swal("Validation Commande:", 
    {
        title: "Etes vous sûr ?",
        text: "souhaitez-vous valider cette commande",
        icon: "warning",
        buttons: true,
    })
    .then((willDelete) => 
    {
        if(willDelete)
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
            xhr.open("POST","http://serveurptb:8000/ValidationCommandeTaxe",true);
            xhr.send(button.id);
            getTaxes();
            updateTab();
        }    
    });
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
    xhr.open("GET","http://serveurptb:8000/json/guichet/",true);
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

 getTaxes();