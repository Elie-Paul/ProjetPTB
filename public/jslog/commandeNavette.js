let index=0;
let selectedrow=0;
const   cmbClasses = document.getElementsByClassName('form-control SectionId');
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
       getJson("http://localhost:8000/json/guichet/",1);
       getJson("http://localhost:8000/json/classe/",2);
       cmbGuichets[index].addEventListener("change",getJson3);
       cmbClasses[index].addEventListener("change",getJson3);
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
            let idClasse= cmbClasses[i].options[cmbClasses[i].selectedIndex].id;
            if(Nbres[i].value =="" && idGuichet=='0' && idClasse=='0')
            {
                
                tbody.removeChild(tbody.children[i]);
                index--;
            }  
        } 
   }
   
}
function removeRow()
{
    /*if (selectedrow!=0) 
    {
        let idGuichet = cmbGuichets[selectedrow-1].options[cmbGuichets[selectedrow-1].selectedIndex].id;
        let idSection = cmbSections[selectedrow-1].options[cmbSections[selectedrow-1].selectedIndex].id;
        if(Nbres[selectedrow-1].value =="" && idGuichet=='0' && idSection=='0')
        {
            
            tbody.removeChild(tbody.children[selectedrow-1]);
            index--;
            Nbres[index].addEventListener("click",addRow);
            addRow();
        }    
    } */
    
}


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
                    setClasse(response);
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
    let idClasse = cmbClasses[selectedrow].options[cmbClasses[selectedrow].selectedIndex].id;
   if(cmbTrajets[selectedrow].children.length>1)
   {
        for(let i=1; i<cmbTrajets[selectedrow].children.length;i++)
        {
            cmbTrajets[selectedrow].removeChild(cmbTrajets[selectedrow].children[i]);
        }
   }
    let link =`http://localhost:8000/json/trajetNavette/${idGuichet}+${idClasse}`;
    console.log(link);
    if (idGuichet!='0' && idClasse!='0')
    {
        getJson(link,3,selectedrow);
    } 
 } 
 function setGuichet(array)
 {
     
     //var array=getJson("http://localhost:8000/json/guichet/");
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
 function setClasse(array)
 {
     
     //var array=getJson("http://localhost:8000/json/guichet/");
     for(let i= 0 ; i<array.length ; i++)
     {
         
          // console.log(array[i].nom);
           let option=document.createElement('option');
           option.id=`${array[i].id}`;
           let t = document.createTextNode(`${array[i].libelle}`);
           //-${array[i].Arrivee}
           option.appendChild(t);
           cmbClasses[index].appendChild(option);
    }
    
 }
 function setTrajet(array,trajetid)
 {
     
     //var array=getJson("http://localhost:8000/json/guichet/");
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
 getJson("http://localhost:8000/json/guichet/",1);
 getJson("http://localhost:8000/json/classe/",2);
 cmbGuichets[index].addEventListener("change",getJson3);
 cmbClasses[index].addEventListener("change",getJson3);
 //cmbGuichets[index].addEventListener("click",(e) =>getElementId(e.target));
 Nbres[index].addEventListener("click",addRow);
 Nbres[index].addEventListener("keyup",checkforEmpty);
 //Nbres[index].addEventListener("focus",removeRow);
 Nbres[index].addEventListener("change",setTotal);
 
 
 function passerCommande() 
 {
    buttonCommande.style.display="none";
    for (let i = 0; i <= index; i++) 
    {
        let idGuichet = cmbGuichets[i].options[cmbGuichets[i].selectedIndex].id;
        let idClasse = cmbClasses[i].options[cmbClasses[i].selectedIndex].id;
        let idTrajet  = cmbTrajets[i].options[cmbTrajets[i].selectedIndex].id;    
        let xhttp=new XMLHttpRequest();
        let a= 0;
        xhttp.onload = function ()
        {
            if ( this.status == 200)
            {
                //let response = JSON.parse();
                //alert(xhttp.responseText);
                ///a++;
                spansSuccess[i].style.display = "block";
                
                
            }
        }
        let link ="http://localhost:8000/newCommandeNavette/";
        let params =`${idGuichet}+${idClasse}+${idTrajet}+${Nbres[i].value}`;
        console.log(params);
        if(Nbres[i].value !="" && idGuichet!='0' && idClasse!='0'&& idTrajet!='0')
        {
            xhttp.open("POST",link,true);
            xhttp.send(params);  
        }
        
        if(i==index)
        {
            setTimeout(function(){ document.location.href = "http://localhost:8000/commande/Navette/";}
            , index*600); 
        }
    } 
    
     
 }
 
 
          