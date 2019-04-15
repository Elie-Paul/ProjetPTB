let index=0;
let selectedrow=0;
const   cmbSections = document.getElementsByClassName('form-control SectionId');
const   cmbGuichets = document.getElementsByClassName('form-control GuichetId');
const   cmbTrajets = document.getElementsByClassName('form-control TrajetId');
const   Nbres = document.getElementsByClassName('form-control nbreBillet');
const   tbody = document.getElementById('tbody');
const spansSuccess =  document.getElementsByClassName('label label-success');
const spansDanger =  document.getElementsByClassName('label label-danger');
const   trows=document.getElementsByClassName('rowsss');
const   total=document.getElementById('total');
const  buttonCommande = document.getElementById('commander');
console.log(trows);

trows[0].addEventListener('mouseenter',(e) => {selectedrow = parseInt(e.target.id);console.log(selectedrow);});

let row=tbody.children[0].cloneNode(true);
function addRow()
{
    
    let test=index-1;
    if(index ==0)
        test=0;
    if(Nbres[test].value!="" || index==0)
    {
        //Nbres[index].removeEventListener("click",addRow);
      //  cmbGuichets[index].removeEventListener("click",(e) =>getElementId(e.target));
      checkforEmpty();
        index++;
        let rowcopy=row.cloneNode(true);
        rowcopy.id=`${index}`; 
        tbody.appendChild(rowcopy);
        Nbres[index].addEventListener("click",addRow);
        Nbres[index].addEventListener("keyup",checkforEmpty);
        //Nbres[index].addEventListener("keyup",removeRow);
       // Nbres[index].addEventListener("focus",removeRow);
        trows[index].addEventListener('mouseenter',(e) => {selectedrow = parseInt(e.target.id);console.log(selectedrow);});
       // cmbGuichets[index].addEventListener("click",(e) =>getElementId(e.target));    
       getJson("http://serveurptb:8000/json/guichet/",1);
       getJson("http://serveurptb:8000/json/section/",2);
       cmbGuichets[index].addEventListener("change",getJson3);
       cmbSections[index].addEventListener("change",getJson3);
       Nbres[index].addEventListener("change",setTotal);
       
       
    }
    
}

function checkforEmpty()
{
   if(index !=0)
   {
        for (let i = 0; i < index; i++) 
        {
            let idGuichet = cmbGuichets[i].options[cmbGuichets[i].selectedIndex].id;
            let idSection = cmbSections[i].options[cmbSections[i].selectedIndex].id;
            if(Nbres[i].value =="" && idGuichet=='0' && idSection=='0')
            {
                
                tbody.removeChild(tbody.children[i]);
                index--;
            }  
        } 
   }
   
}
/*function reset()
{
    for(let i=1;i<tbody.children;i++)
    {
        tbody.children[i].remove(children.)
    }
    
}*/


 function getJson(link,id,trajetid)
 {
     let xhttp=new XMLHttpRequest();
     xhttp.onreadystatechange = function()
     {
         if (this.readyState == 4 && this.status == 200)
         {
             let response = JSON.parse(xhttp.responseText);
             //console.log(response);
             switch (id) 
             {
                case 1:
                    setGuichet(response);
                    break;
                case 2:
                    setSection(response);
                    break;                    
                case 3:
                    setTrajet(response,trajetid);
                    console.log(link+"ss");
                    break;
             }
             
         }
     }
     xhttp.open("GET",link,true);
     xhttp.send();
 }
function getJson3()
 {
    let idGuichet = cmbGuichets[selectedrow].options[cmbGuichets[selectedrow].selectedIndex].id;
    let idSection = cmbSections[selectedrow].options[cmbSections[selectedrow].selectedIndex].id;
   if(cmbTrajets[selectedrow].children.length>1)
   {
        for(let i=1; i<cmbTrajets[selectedrow].children.length;i++)
        {
            cmbTrajets[selectedrow].removeChild(cmbTrajets[selectedrow].children[i]);
        }
   }
    let link =`http://serveurptb:8000/json/trajet/${idGuichet}+${idSection}`;
    console.log(link);
    if (idGuichet!='0' && idSection!='0')
    {
        getJson(link,3,selectedrow);
    } 
 } 
 function setGuichet(array)
 {
     
     //var array=getJson("http://serveurptb:8000/json/guichet/");
     for(let i= 0 ; i<array.length ; i++)
     {
         
          // console.log(array[i].nom);
           let option=document.createElement('option');
           option.id=`${array[i].id}`;
           let t = document.createTextNode(`${array[i].nom}`);
           option.appendChild(t);
           cmbGuichets[index].appendChild(option);
           
      }
      
 }
 function setSection(array)
 {
     
     //var array=getJson("http://serveurptb:8000/json/guichet/");
     for(let i= 0 ; i<array.length ; i++)
     {
         
          // console.log(array[i].nom);
           let option=document.createElement('option');
           option.id=`${array[i].id}`;
           let t = document.createTextNode(`${array[i].libelle}`);
           //-${array[i].Arrivee}
           option.appendChild(t);
           cmbSections[index].appendChild(option);
    }
    
 }
 function setTrajet(array,trajetid)
 {
     
     //var array=getJson("http://serveurptb:8000/json/guichet/");
     for(let i= 0 ; i<array.length ; i++)
     {
         
          // console.log(array[i].nom);
           let option=document.createElement('option');
           option.id=`${array[i].id}`;
           let t = document.createTextNode(`${array[i].Depart}-${array[i].Arrivee}`);
           //-${array[i].Arrivee}
           option.appendChild(t);
           cmbTrajets[trajetid].appendChild(option);
           
      }
 }     
 function setTotal()
 {
    let tot=0;
    for(let i= 0 ; i<Nbres.length ; i++)
    {
        if(Nbres[i].value != '')
        {
            tot += parseInt(Nbres[i].value); 
        }
    }
    checkforEmpty() 
    total.innerText=""+tot;
 } 
 getJson("http://serveurptb:8000/json/guichet/",1);
 getJson("http://serveurptb:8000/json/section/",2);
 cmbGuichets[index].addEventListener("change",getJson3);
 cmbSections[index].addEventListener("change",getJson3);
 //cmbGuichets[index].addEventListener("click",(e) =>getElementId(e.target));
 Nbres[index].addEventListener("click",addRow);
 Nbres[index].addEventListener("keyup",checkforEmpty);
 //Nbres[index].addEventListener("focus",removeRow);
 Nbres[index].addEventListener("change",setTotal);
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
            document.location.href="http://serveurptb:8000/commande/ptb";
            
        });
 } 
 
 function passerCommande() 
 {
    buttonCommande.style.display="none";
    for (let i = 0; i <= index; i++) 
    {
        let idGuichet = cmbGuichets[i].options[cmbGuichets[i].selectedIndex].id;
        let idSection = cmbSections[i].options[cmbSections[i].selectedIndex].id;
        let idTrajet  = cmbTrajets[i].options[cmbTrajets[i].selectedIndex].id;    
        let xhttp=new XMLHttpRequest();
     /*xhttp.onreadystatechange = function()
     {
         if (this.readyState == 4 && this.status == 200)
         {
             //let response = JSON.parse();
             alert(xhttp.responseText);
             
             
         }
     }*/
     let a= 0;
     xhttp.onload = function ()
     {
        if ( this.status == 200)
        {
            spansSuccess[i].style.display = "block";
            spansDanger[i].style.display = "none";
        }
        else
        {
            spansDanger[i].style.display = "block";
            spansSuccess[i].style.display = "none";
        }

     }
     let link ="http://serveurptb:8000/newCommande/";
     let params =`${idGuichet}+${idSection}+${idTrajet}+${Nbres[i].value}`;
     console.log(params);
     if(Nbres[i].value !="" && idGuichet!='0' && idSection!='0'&& idTrajet!='0')
     {
        xhttp.open("POST",link,false);
        xhttp.send(params);  
     }
     
     if(i==index)
     {
        
        afterCommande();
        
     }
    } 
    
     
 }
 
 
          