
let index=0;
const   cmbSections = document.getElementsByClassName('form-control SectionId');
const   cmbGuichets = document.getElementsByClassName('form-control GuichetId');
const   cmbTrajets = document.getElementsByClassName('form-control TrajetId');
const   Nbres = document.getElementsByClassName('form-control nbreBillet');
const   tbody = document.getElementById('tbody');

let row=tbody.children[0].cloneNode(true);
function getElementId(element)
{
    alert(element.parentElement.parentElement.parentElement.id);
}
console.log(cmbGuichets);
function addRow()
{
    
    let test=index-1;
    if(index ==0)
        test=0;
    if(Nbres[test].value!="" || index==0)
    {
        Nbres[index].removeEventListener("click",addRow);
        cmbGuichets[index].removeEventListener("click",(e) =>getElementId(e.target));
        index++;
        let rowcopy=row.cloneNode(true);
        rowcopy.id=`row${index}`; 
        tbody.appendChild(rowcopy);
        Nbres[index].addEventListener("click",addRow);
        cmbGuichets[index].addEventListener("click",(e) =>getElementId(e.target));    
    }
    
}


function removeRow()
{

}


 function getJson(link,id)
 {
     let xhttp=new XMLHttpRequest();
     xhttp.onreadystatechange = function()
     {
         if (this.readyState == 4 && this.status == 200)
         {
             let response = JSON.parse(xhttp.responseText);
             console.log(response);
             switch (id) 
             {
                case 1:
                    setGuichet(response.notes);
                    break;
                case 2:
                    setSection(response.notes);
                    break;                    
                case 3:
                    setTrajet(response);
                    cmbTrajets[index].removeEventListener("mouseenter",getJson3);
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
    let idGuichet = cmbGuichets[index].options[cmbGuichets[index].selectedIndex].id;
    let idSection = cmbSections[index].options[cmbSections[index].selectedIndex].id;
   if(cmbTrajets[index].children.length>1)
   {
        for(let i=1; i<cmbTrajets[index].children.length;i++)
        {
            cmbTrajets[index].removeChild(cmbTrajets[index].children[i]);
        }
   }
    let link =`http://localhost:8000/json/trajet/${idGuichet}+${idSection}`;
    console.log(link);
    if (idGuichet!='' && idSection!='')
    {
        getJson(link,3);
    } 
 } 
 function setGuichet(array)
 {
     
     //var array=getJson("http://localhost:8000/json/guichet/");
     for(let i= 0 ; i<array.length ; i++)
     {
         
           console.log(array[i].nom);
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
         
           console.log(array[i].nom);
           let option=document.createElement('option');
           option.id=`${array[i].id}`;
           let t = document.createTextNode(`${array[i].libelle}`);
           //-${array[i].Arrivee}
           option.appendChild(t);
           cmbSections[index].appendChild(option);
    }
    
 }
 function setTrajet(array)
 {
     
     //var array=getJson("http://localhost:8000/json/guichet/");
     for(let i= 0 ; i<array.length ; i++)
     {
         
           console.log(array[i].nom);
           let option=document.createElement('option');
           option.id=`${array[i].id}`;
           let t = document.createTextNode(`${array[i].Depart}-${array[i].Arrivee}`);
           //-${array[i].Arrivee}
           option.appendChild(t);
           cmbTrajets[index].appendChild(option);
           
      }
 }      
 getJson("http://localhost:8000/json/guichet/",1);
 getJson("http://localhost:8000/json/section/",2);
 cmbGuichets[index].addEventListener("change",getJson3);
 cmbSections[index].addEventListener("change",getJson3);
 cmbGuichets[index].addEventListener("click",(e) =>getElementId(e.target));
    Nbres[index].addEventListener("click",addRow);
 
 
 
 //test.addEventListener("click",() =>addRow());
          