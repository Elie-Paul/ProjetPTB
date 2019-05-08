
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
            let ca=0;
            let voyageur=0;
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
                ca +=vente.prix;
                voyageur +=vente.voyageurs;
              }  
            )
            billet.totalVente = totalVente;
            billet.totalCmd = totalCommande;
            billet.totalReal = totalCommandeReal;
            billet.ca= ca;
            billet.voyageur = voyageur;
            billet.prime = (ca*5)/1000
            let arr = [billet.billet,billet.guichet,billet.type,
            billet.totalCmd,billet.totalReal,billet.totalVente,billet.ca,billet.voyageur,billet.totalReal - billet.totalVente,billet.prime];
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

  if(start.value == '' && end.value == '' && etatSelected ===0)
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
        billet.ventes.filter((value,index) =>
        {
            a=true;
            let date = new Date(value.date.date);
              if(DateCompare(date,dstart))
              {
                a= true;
                
                
              }
              else if(DateCompare(date,dend))
              {
                a=true;
                
              }
              else if(date > dstart && date < dend)
              {
                  a=true;
                  
                
              }
              else
              {
                a=false;
                value.nbre=0;
                
              } 
           });
            
          if(a)
           return a;
          else
           return false;

      });
      //makeGuichetVente(graphData);
      //addRow(tabData);
      
      if(start.value == '' && end.value == '' && etatSelected ===0)
  {
    getAllCommande();
  }
      
  }
  //$("#example1").DataTable().clear().draw();

  console.log(tab1);
  setTotal(tab1);
  if(start.value == '' && end.value == '' && etatSelected ===0)
  {
    getAllCommande();
  }


}


getAllCommande();


function setDataTable(dataSet)
{

   
     
    //$("#example1").dataTable().fnDestroy();
    console.log(dataSet);
    
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
                    { title: "CA(FCFA)" },
                    { title: "Voyageur" },
                    { title: "Invendu" },
                    { title: "prime(5/1000)" }
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
                        extend: 'print', footer: true,
                        text: '<i class="fa fa-print"></i> Imprimer',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend:'excel', footer: true,
                        text: '<i class="fa fa-file-excel-o"></i> Excel'
                    },
                    {
                        extend:'csv', footer: true,
                        text: '<i class="fa fa-file-text-o"></i> CSV'
                    },
                    {
                        extend:'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDf'
                    },
                    {
                        extend: 'colvis',
                        text: 'Colonnes visibles', footer: true
                    }
                ],
                columnDefs: [ {
                    visible: false
                } ],
              "footerCallback": function ( row, data, start, end, display ) {
            
              var api = this.api(), data;
   
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
   
              // Total over all pages
              total = api
                  .column( 5 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
              // Total over this page
              pageTotal = api
                  .column( 5, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
   
              // Update footer
              $( api.column( 5 ).footer() ).html(
                  'billets vendu:'+pageTotal 
              );
              total = api
              .column( 6 )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Total over this page
          pageTotal = api
              .column( 6, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Update footer
          $( api.column( 6 ).footer() ).html(
              'CA:'+pageTotal+'FCFA' 
          );
          total = api
          .column( 7 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

      // Total over this page
      pageTotal = api
          .column( 7, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

      // Update footer
      $( api.column( 7 ).footer() ).html(
          'Voyageurs:'+pageTotal 
      );
      total = api
      .column( 8 )
      .data()
      .reduce( function (a, b) {
          return intVal(a) + intVal(b);
      }, 0 );

  // Total over this page
  pageTotal = api
      .column( 8, { page: 'current'} )
      .data()
      .reduce( function (a, b) {
          return intVal(a) + intVal(b);
      }, 0 );

  // Update footer
  $( api.column( 8 ).footer() ).html(
      'deficit:'+pageTotal 
  );
  total = api
      .column(4)
      .data()
      .reduce( function (a, b) {
          return intVal(a) + intVal(b);
      }, 0 );

  // Total over this page
  pageTotal = api
      .column( 4, { page: 'current'} )
      .data()
      .reduce( function (a, b) {
          return intVal(a) + intVal(b);
      }, 0 );

  // Update footer
  $( api.column( 4 ).footer() ).html(
      'dotation:'+pageTotal 
  );

  // Total over this page
  pageTotal = api
      .column( 9, { page: 'current'} )
      .data()
      .reduce( function (a, b) {
          return intVal(a) + intVal(b);
      }, 0 );
      let test75 = (pageTotal*5)/1000
      pageTotal2=0;
                if(test75<5000)
      {
        pageTotal2=5000;
      }
      else
      {
        pageTotal2 = Math.round(test75);
      }

  // Update footer
  $( api.column( 9 ).footer() ).html(
      'Prime:'+pageTotal2+'FCFA'
  );
      
          }
          
            })
            
            table.buttons().container()
                .appendTo( '#example1_wrapper .col-sm-6:eq(0)' );

                
            
        }
        )
    
        
        
}