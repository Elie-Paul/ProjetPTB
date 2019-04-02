let array =[];
window.onload = function () 
{
    
    let xhr=new XMLHttpRequest();
    const start = document.getElementById('start');
    const end = document.getElementById('end');
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
    xhr.open("GET","http://localhost:8000/json/guichet2vente/",true);
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
        array.forEach(element => 
       {
            let total = 0;
            element.commande.forEach(element2 =>
            {
                total+=element2.nombreBilletVendu;
            });
            let venteGuichet={y:total,label:""+element.guichet};
            graphData.push(venteGuichet);  
       });
       makeGuichetVente(graphData);
   }
function makeGuichetVente(tab)
{
    var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    exportEnabled: true,
    theme: "light2", // "light1", "light2", "dark1", "dark2"
    title:
    {
        text: "Nombre de Vente par Guichet"
    },
    axisY: 
    {
		title: "Nombre de vente",
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

function updateTab()
{
    let tab1 = array;
    if(start.value == '' && end.value == '')
    {
        makeGuichetVente(array);
    }
    if(start.value != '' && end.value != '')
    {
        let dstart = new Date(start.value);
        let dend = new Date(end.value);
        let graphData=[];
        tab1 = tab1.filter((value1)=>
        {
            let total=0;
            value1.commande.filter((value) =>
            {
                var date = new Date(value.dateCommande.date);
                if(DateCompare(date,dstart))
                {
                    console.log("true");
                    total+=value.nombreBilletVendu;
                    return true;
                }
                else if(DateCompare(date,dend))
                {
                    console.log("true");
                    total+=value.nombreBilletVendu;
                    return true;
                }
                else if(date > dstart && date < dend)
                {
                    console.log("true");
                    total+=value.nombreBilletVendu;
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
        makeGuichetVente(graphData);

    }
  

}