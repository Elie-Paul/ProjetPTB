let array1 =[];
const tbody1 = document.getElementById('tbody1');
const start = document.getElementById('start1');
const end = document.getElementById('end1');

window.onload = function () 
{
    
    let xhr=new XMLHttpRequest();
    
    start.addEventListener('change',updateTab2);
    end.addEventListener('change',updateTab2);
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            console.log(JSON.parse(this.responseText));
            graphArray2(JSON.parse(this.responseText));
            array1 =JSON.parse(this.responseText);
            
        }
    }
    xhr.open("GET","http://serveurptb:8000/json/guichet2vente/",true);
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
   function graphArray2(array)
   {
       let graphData=[];
       let tabData=[];
       //console.log(array1);
        array.forEach(element => 
       {
            let total = 0;
            element.commandes.forEach(commande =>
            {
                total+=commande.nombreBilletRealiser;
                tabData.push({guichet:element.guichet,date:commande.dateCommande,nbre:commande.nombreBilletRealiser});
            });
            let commandeGuichet={y:total,label:""+element.guichet};
            graphData.push(commandeGuichet);  
       });
      // console.log(graphData);
      makeGuichetCommande(graphData);
     //  addRow2(tabData);
   }
   function addRow2(array) 
{
    while (tbody1.firstChild) 
    {
        tbody1.removeChild(tbody1.firstChild);
    }
   
    for (let index = 0; index < array.length; index++) 
    {
        let tr = document.createElement('tr');
        tr.id=array[index].id;
        let arr=createRowElement2(array[index]);
        arr.forEach((value) => tr.appendChild(value));
        tbody1.appendChild(tr);
    }
    function createRowElement2(element)
    {
        let array=[];
        
        let guichet = document.createElement('td');
        let guichetContent = document.createTextNode(element.guichet);
        guichet.appendChild(guichetContent);
        array.push(guichet);
        
        let nbreCommande = document.createElement('td');
        let nbreCommandeContent = document.createTextNode(element.nbre);
        nbreCommande.appendChild(nbreCommandeContent);
        array.push(nbreCommande);
    
        let dateCommande = document.createElement('td');
        dateCommande.style.width="180px";
        var d = new Date(element.date.date);
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        let dateCommandeContent = document.createTextNode(`${d.toLocaleDateString('fr-FR', options)}`);
        dateCommande.appendChild(dateCommandeContent);
        array.push(dateCommande);
        return array;
    }
}
function makeGuichetCommande(tab)
{
    var chart = new CanvasJS.Chart("chartContainer1", {
    animationEnabled: true,
    exportEnabled: true,
    theme: "light2", // "light1", "light2", "dark1", "dark2"
    title:
    {
        text: " commande de billetPTB par Guichet "+start.value+"   "+end.value
    },
    axisY: 
    {
		suffix: "billets"
	},
        axisX: 
    {
		title: "Guichet"
	},
    data: 
    [
        {
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",
		dataPoints: tab
        }
    ]    
    });
    chart.render();
}

function updateTab2()
{
    let tab1 = array1;
    if(start.value == '' && end.value == '')
    {
        graphArray2(array);
    }
    if(start.value != '' && end.value != '')
    {
        let dstart = new Date(start.value);
        let dend = new Date(end.value);
        let graphData=[];
        let tabData=[];
        tab1 = tab1.filter((value1)=>
        {
            let total=0;
            value1.commandes.filter((value) =>
            {
                var date = new Date(value.dateCommande.date);
                if(DateCompare(date,dstart))
                {
                    console.log("true");
                    total+=value.nombreBilletRealiser;
                    tabData.push({guichet:value1.guichet,date:value.dateCommande,nbre:value.nombreBilletRealiser});
                    return true;
                }
                else if(DateCompare(date,dend))
                {
                    console.log("true");
                    total+=value.nombreBilletRealiser;
                    tabData.push({guichet:value1.guichet,date:value.dateCommande,nbre:value.nombreBilletRealiser});
                    return true;
                }
                else if(date > dstart && date < dend)
                {
                    console.log("true");
                    total+=value.nombreBilletRealiser;
                    tabData.push({guichet:value1.guichet,date:value.dateCommande,nbre:value.nombreBilletRealiser});
                    return true;
                }
                else
                {
                    console.log("false");
                    return false;
                } 

            });
            let venteGuichet={y:total,label:""+value1.guichet};
            graphData.push(venteGuichet);  

                
        });
        makeGuichetCommande(graphData);
        //addRow2(tabData);

    }
  

}