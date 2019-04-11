let array =[];
const tbody = document.getElementById('tbody');
const start = document.getElementById('start');
const end = document.getElementById('end');
window.onload = function () 
{
    
    let xhr=new XMLHttpRequest();
   
    start.addEventListener('change',updateTab);
    end.addEventListener('change',updateTab);
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            console.log(JSON.parse(this.responseText));
            graphArray(JSON.parse(this.responseText));
            array =JSON.parse(this.responseText);
            
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
   function graphArray(array)
   {
       let graphData=[];
       let tabData=[];
        array.forEach(element => 
       {
            let total = 0;
            element.ventes.forEach(vente =>
            {
                total+=vente.nbre;
                tabData.push({guichet:element.guichet,date:vente.date,nbre:vente.nbre});
            });
            let venteGuichet={y:total,label:""+element.guichet};
            graphData.push(venteGuichet);  
       });
       let graphData1=[];
       let tabData1=[];
     
        array.forEach(element => 
       {
            let total = 0;
            element.commandes.forEach(commande =>
            {
                total+=commande.nombreBilletRealiser;
                tabData1.push({guichet:element.guichet,date:commande.dateCommande,nbre:commande.nombreBilletRealiser});
            });
            let commandeGuichet={y:total,label:""+element.guichet};
            graphData1.push(commandeGuichet);  
       });
       makeGuichetVente(graphData,graphData1);
   }
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
    function createRowElement(element)
{
    let array=[];
    
    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(element.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);
    
    let vente = document.createElement('td');
    let venteContent = document.createTextNode(element.nbre);
    vente.appendChild(venteContent);
    array.push(vente);
   
    let dateVente = document.createElement('td');
    dateVente.style.width="180px";
    var d = new Date(element.date.date);
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    let dateVenteContent = document.createTextNode(`${d.toLocaleDateString('fr-FR', options)}`);
    dateVente.appendChild(dateVenteContent);
    array.push(dateVente);
    return array;
}
}
function makeGuichetVente(arr,arr1)
{
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        
        exportEnabled: true,
        title:{
            text: "vente/commande billet PTB"
        },	
        axisY: {
            title: "vente billet PTB",
            titleFontColor: "#4F81BC",
            lineColor: "#4F81BC",
            labelFontColor: "#4F81BC",
            tickColor: "#4F81BC"
        },
        axisY2: {
            title: "commande billet PTB",
            titleFontColor: "#C0504E",
            lineColor: "#C0504E",
            labelFontColor: "#C0504E",
            tickColor: "#C0504E"
        },	
        toolTip: {
            shared: true
        },
       
        
        data: [{
            type: "column",
            name: "vente billet PTB",
            legendText: "vente billet PTB",
            showInLegend: true, 
            dataPoints:arr
        },
        {
            type: "column",	
            name: "commande billet PTB",
            legendText: "commande billet PTB",
            axisYType: "secondary",
            showInLegend: true,
            dataPoints:arr1,
        }]
    });
    chart.render();
}

function updateTab()
{
    let tab1 = array;
    if(start.value == '' && end.value == '')
    {
        graphArray(array);
    }
    if(start.value != '' && end.value != '')
    {
        let dstart = new Date(start.value);
        let dend = new Date(end.value);
        let graphData=[];
        let graphData1=[];
        let tabData=[];
        let tab2=tab1
        tab1 = tab1.filter((value1)=>
        {
            let total=0;
            value1.ventes.filter((value) =>
            {
                var date = new Date(value.date.date);
                if(DateCompare(date,dstart))
                {
                    console.log("true");
                    total+=value.nbre;
                    tabData.push({guichet:value1.guichet,date:value.date,nbre:value.nbre});
                    return true;
                }
                else if(DateCompare(date,dend))
                {
                    console.log("true");
                    total+=value.nbre;
                    tabData.push({guichet:value1.guichet,date:value.date,nbre:value.nbre});
                    return true;
                }
                else if(date > dstart && date < dend)
                {
                    console.log("true");
                    total+=value.nbre;
                    tabData.push({guichet:value1.guichet,date:value.date,nbre:value.nbre});
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
        tab2 = tab2.filter((value1)=>
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
            graphData1.push(venteGuichet);  

                
        });
        
        makeGuichetVente(graphData,graphData1);
        addRow(tabData);

    }
  

}