let index=0;
let selectedrow=0;
const   cmbSections = document.getElementsByClassName('form-control SectionId');
const   cmbGuichets = document.getElementsByClassName('form-control GuichetId');
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
       getJson("http://localhost:8000/json/type/",2);
       
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
             }
             
         }
     }
     xhttp.open("GET",link,true);
     xhttp.send();
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
 function setSection(array)
 {
     
     //var array=getJson("http://localhost:8000/json/guichet/");
     for(let i= 0 ; i<array.length ; i++)
     {
         
          // console.log(array[i].nom);
           let option=document.createElement('option');
           option.id=`${array[i].id}`;
           let t = document.createTextNode(`${array[i].section}:${array[i].nom}`);
           //-${array[i].Arrivee}
           option.appendChild(t);
           cmbSections[index].appendChild(option);
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
 getJson("http://localhost:8000/json/type/",2);
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
        text: "Toute vos commande on été envoyé",
        icon: "success",
        
    })
        .then((value) => {
            document.location.href="http://localhost:8000/commande/vignette";
            
        });
 } 
 
 function passerCommande() 
 {
    buttonCommande.style.display="none";
    for (let i = 0; i <= index; i++) 
    {
        let idGuichet = cmbGuichets[i].options[cmbGuichets[i].selectedIndex].id;
        let idSection = cmbSections[i].options[cmbSections[i].selectedIndex].id;
            
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
            //let response = JSON.parse();
            //alert(xhttp.responseText);
            ///a++;
            spansSuccess[i].style.display = "block";
            
            
        }
     }
     let link ="http://localhost:8000/newCommandeVignette/";
     let params =`${idGuichet}+${idSection}+${Nbres[i].value}`;
     console.log(params);
     if(Nbres[i].value !="" && idGuichet!='0' && idSection!='0')
     {
        xhttp.open("POST",link,true);
        xhttp.send(params);  
     }
     
     if(i==index)
     {
        setTimeout(function()
        {   
            afterCommande();
        }
        , index*700); 
     }
    } 
    
     
 }
 
 
          