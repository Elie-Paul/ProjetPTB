
const tbody = document.getElementById('tbody');
const cmbEtat = document.getElementById('etat');

const today = new Date();
const start = document.getElementById('start');
const end = document.getElementById('end');
var tab =[];


cmbEtat.addEventListener('change',updateTab);
start.addEventListener('change',updateTab);
end.addEventListener('change',updateTab);


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
function getAllCommande()
{
    let xhr=new XMLHttpRequest();
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            console.log(JSON.parse(this.responseText));
            tab = JSON.parse(this.responseText);
            setTotal(tab);
            
        }
    }
    xhr.open("GET",superLink+"/json/statBillets/Vente/",false);
    xhr.send();

}
function setTotal(array)
{
   let tab2= [];
    array.forEach(
        (billet) =>
        {
            let totalCommandeReal=0;
            let totalCommande=0;
            let totalVente=0;
            billet.commandes.forEach(
                (commande) =>
                {
                     totalCommandeReal += commande.nombreBilletRealiser;
                     totalCommande += commande.nombreDeBilletCommander;

                }
            )
            billet.ventes.forEach(
              (vente) =>
              {
                totalVente += vente.nbre;
              }  
            )
            billet.totalVente = totalVente;
            billet.totalCmd = totalCommande;
            billet.totalReal = totalCommandeReal;
            let arr = [billet.billet,billet.guichet,billet.type,
            billet.totalCmd,billet.totalReal,billet.totalVente,billet.totalReal - billet.totalVente];
            tab2.push(arr);
        }
           
    )
    setDataTable(tab2);
    //addRow(array);
    
}

function updateTab()
{
    
  /*let dateSelected = cmbDate.selectedIndex;*/
  let etatSelected = cmbEtat.selectedIndex;
  let tab1 = tab;

  if(start.value == '' && end.value == '' && etatSelected ==0)
  {
    getAllCommande();
  }
 
  if(etatSelected !==0)
  {
        
       // alert(etatSelected);
        tab1 = tab1.filter((value)=>
        {
            
            let sss=etatSelected - 1;
            //alert(sss+":::::"+value.etat);
            if (cmbEtat.value == value.type)
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

    tab1 = tab1.filter((billet)=>
      {
          
        let a=false;  
        billet.ventes.filter((value) =>
        {
            a=true;
            let date = new Date(value.date.date);
              if(DateCompare(date,dstart))
              {
                return true;
              }
              else if(DateCompare(date,dend))
              {
                return true;
              }
              else if(date > dstart && date < dend)
              {
                  
                return true;
              }
              else
              {
                a=false;
                return false;
              } 
           });
            billet.commandes.filter((value) =>
          {
            a=true;  
            let date = new Date(value.date.date);
              if(DateCompare(date,dstart))
              {
                return true;
              }
              else if(DateCompare(date,dend))
              {
                return true;
              }
              else if(date > dstart && date < dend)
              {
                  
                return true;
              }
              else
              {
                a=false;
                return false;
              } 
           });
          //let venteGuichet={y:total,label:""+value1.guichet};
          //graphData.push(venteGuichet);  
          if(a)
           return a;
          else
           return false;

      });
      //makeGuichetVente(graphData);
      //addRow(tabData);
      
      
      
  }
  //$("#example1").DataTable().clear().draw();

  console.log(tab1);
  setTotal(tab1);

}


getAllCommande();


function setDataTable(dataSet)
{

   
     
    //$("#example1").dataTable().fnDestroy();
    
    $.fn.dataTable.moment( 'DD-MM-YYYY HH:mm:SS' );
    $(function () {
            $('#example1').DataTable({
                "reponsive": true,
                "pageLength": 10,
                data: dataSet,
                columns: [
                    { title: "Billet" },
                    { title: "Guichet" },
                    { title: "type" },
                    { title: "Nombre Commandé" },
                    { title: "Nombre Realisé" },
                    { title: "Nombre Vendu" },
                    { title: "Invendu" }
                ],
                "destroy":true,
                "language": 
                {
                    "decimal":        "",
                    "loadingRecords": "Chargement...",
                    "processing":     "En traitement...",
                    "lengthMenu":     "Afficher _MENU_ entrées",
                    "zeroRecords":    "Aucun enregistrements correspondants trouvés",
                    "emptyTable":     "aucune donnée disponible",
                    "infoFiltered":   "(filtré de _MAX_ entrées totales)",
                    "infoEmpty":      "Affiche 0 à 0 sur 0 entrées",
                    "info": "Affiche _START_ à _END_ sur _TOTAL_ entrées",
                    "search": "Rechercher : ",
                    "paginate": {
                        "first": "Premier",
                        "last":  "Dernier",
                        "previous": "Précédent",
                        "next": "Suivant"
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Imprimer',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend:'excel',
                        text: '<i class="fa fa-file-excel-o"></i> Excel'
                    },
                    {
                        extend:'csv',
                        text: '<i class="fa fa-file-text-o"></i> CSV'
                    },
                    {
                        extend:'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDf'
                    },
                    {
                        extend: 'colvis',
                        text: 'Colonnes visibles'
                    }
                ],
                columnDefs: [ {
                    visible: false
                } ]
            })
            table.buttons().container()
                .appendTo( '#example1_wrapper .col-sm-6:eq(0)' );
            
        })
}