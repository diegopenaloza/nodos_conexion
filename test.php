<!DOCTYPE html>
<html>
<head>
  
  <link href="style.css" rel="stylesheet" type="text/css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis-network.min.js"></script>
 
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</head>
<style>

#mynetwork{
    height: 900px;
    weight: 900px;
}

</style>
<body>



<div id="wrapper">

<div id="mynetwork" >
  <lottie-player id="lottie" src="https://assets8.lottiefiles.com/packages/lf20_c2h6pryr.json" background="transparent" speed="1" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);  width: 350px; height: 350px;" loop autoplay></lottie-player>
</div>




  <script>


var EDGE_LENGTH_SUB = 50;
    var titleElement = document.createElement("div");
titleElement.style.border = "1px solid gray";
titleElement.style.height = "10em";
titleElement.style.width = "10em";
    var container = document.getElementById('mynetwork');

    var nodes=[];
    

    var data = {
      nodes: nodes,
      edges: []
    };


<?php
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

// Array para guardar los IDs ya procesados
$processedIds = array();

function procesarProveedor($id, $manager, &$processedIds, $color='#e85d04',
$icon='https://cdn-icons-png.flaticon.com/512/9710/9710949.png',
$value=1,$tipo='AC',$label='Persona Natural',
$mass= 15 , 
$fixed= True,
$shape= 'square',
$image='https://cdn-icons-png.flaticon.com/512/3106/3106773.png',
$xp= 0,
$yp= 0


) {

    
    // Verificar si el ID ya fue procesado
    if (in_array($id, $processedIds)) {
        return;
    }
    
    // Agregar el ID al array de IDs procesados
    array_push($processedIds, $id);

    $query = new MongoDB\Driver\Query(["proveedor" => $id]);
    $cursor = $manager->executeQuery('Test.Proveedores', $query);

    $text_title = " $label";
  
    
    echo "data.nodes.push({id: '$id', label: '...',shape: 'image',
      title: '$text_title',  
        image: '$icon',
        value: $value,
        mass: $mass,
        color: { background: '$color' , border: 'rgba(255, 255, 255, 0)' },  
      
        fixed:  false ,
        x: $xp,
        y: $yp
       
      
      });\n";

        
        if ($tipo!='EP'){
    $query_2 = new MongoDB\Driver\Query(["Identificación" =>$id]);
    $cursor_3 = $manager->executeQuery('Test.personas', $query_2);
    // $results_3 = $cursor_3->toArray();
     
    foreach ($cursor_3 as $document) {
        // echo "data.nodes.push({id: '".$document->empresa."', label: '".$document->empresa."'});\n";
        echo "data.edges.push({from: '$id',
          to: '".$document->RUC_empresa."',
          color: {
            color: 'blue',  // Establecer el color de la conexión
            highlight: 'blue'  // Establecer el color de resaltado de la conexión
          },
           length: 150,
           arrows: {from: {fromOffset: 200}}
        
        
        
        });\n";
        if ($document->RUC_empresa!== $id) {
            procesarProveedor($document->RUC_empresa, $manager, $processedIds, $color='#4cc9f0',
            $icon='https://cdn-icons-png.flaticon.com/512/9446/9446198.png',
            $value=1,
            $tipo='SA',
            $label=4,
            $mass= 5,
            $fixed= false,
            $shape= 'diamond',
            $image= 'https://cdn-icons-png.flaticon.com/512/554/554724.png',
            $xp= 10,
            $yp= 10
            
          );
        }
    }
  }

  if ($tipo!='EP') {
    $query_4 = new MongoDB\Driver\Query(['releases.awards.suppliers.id' => ['$regex' => $id]]);
    $cursor_4 = $manager->executeQuery('Test.Test', $query_4);
    // $results_4 = $cursor_4->toArray();
  
    foreach ($cursor_4 as $document) {
        // echo "data.nodes.push({id: '".$document->releases[0]->buyer->id."', label: '".$document->releases[0]->buyer->id."'});\n";
        echo "data.edges.push({
          from: '$id', to: '".$document->releases[0]->buyer->id."',
          color: {
            color: 'orange',  // Establecer el color de la conexión
            highlight: 'orange'  // Establecer el color de resaltado de la conexión
          },
           arrows: {to: {fromOffset: 200}}
        
        });\n";
        if ($document->releases[0]->buyer->id !== $id) {
        procesarProveedor($document->releases[0]->buyer->id, $manager, $processedIds, 
        $color='rgb(255, 255, 255)', 
        $icon='https://cdn-icons-png.flaticon.com/512/9638/9638966.png'
        ,$value=1,
        $tipo='EP',
        $label=$document->releases[0]->buyer->name,
        $mass= 0,
        $fixed= false,
        $shape= 'diamond',
        $image= 'https://cdn-icons-png.flaticon.com/512/1733/1733598.png',
        $xp= 10,
        $yp= 10
       
      );
        }
    }
  }

}


$a = '0990320810001';

// 105715924

// 0990320810001

// 1791754115001

// 1790008967001

// 0991312080001

procesarProveedor($a, $manager, $processedIds,$label='2');
?>
// document.getElementById("text").innerText = "<?php echo $a  ?>"

var ruc = "<?php echo $a ?>";
// var options = {
//   tooltip: {
//     hide: false
//   },
//   interaction: {
//     tooltipDelay: 0.2,
//     hover: true,
//     dragNodes: true,
//     dragView: true
//   }
// };

var options = {
  interaction: {
    tooltipDelay: 0.2,
    hover: true,
    dragNodes: true,
    dragView: true
  },
  edges: {
    // color: {color:'green'},
    edgeOffset: 10 ,

    // length: 500,
    arrowStrikethrough: false,
    smooth: false,
    arrows: {
      to: {
        enabled: true,
        type: 'arrow',
        scaleFactor: 0.5,
        strokeColor: '#FF0000' ,// aquí se define el color del borde
        edgeType: "curve" 
      },
      from:{

        enabled: true,
        type: "circle",

        from: "fromPoint",
        scaleFactor: 0,
        offset: 30
      }
      
    },
    label: {
      background: '#ffffff',
      font: {
        color: '#000000',
        size: 14,
      },
    },
  },
  // Deshabilitar la física de todos los nodos
  physics: true,

};




    var network = new vis.Network(container, data, options);







  network.on("beforeDrawing", function (ctx) {
  var nodeId = ruc;
  var nodePosition = network.getPositions([nodeId]);
  ctx.strokeStyle = "white";
  ctx.fillStyle = "#fcbf49";

  ctx.beginPath();
  ctx.arc(
    nodePosition[nodeId].x,
    nodePosition[nodeId].y,
    35,
    0,
    2 * Math.PI,
    false
  );
  ctx.closePath();

  ctx.fill();
  ctx.stroke();


  ctx.strokeStyle = "white";
  ctx.fillStyle = "white";

  ctx.beginPath();
  ctx.arc(
    nodePosition[nodeId].x,
    nodePosition[nodeId].y,
    27,
    0,
    2 * Math.PI,
    false
  );
  ctx.closePath();

  ctx.fill();
  ctx.stroke();



  // ctx.strokeStyle = "white";
  // ctx.fillStyle = "#fb8500";

  // ctx.beginPath();
  // ctx.arc(
  //   nodePosition[nodeId].x,
  //   nodePosition[nodeId].y,
  //   20,
  //   0,
  //   2 * Math.PI,
  //   false
  // );
  // ctx.closePath();

  // ctx.fill();
  // ctx.stroke();


  
});


network.on("click", (params) => {
    if(params.nodes.length>0){
    // Eliminar el div anterior si existe
    var previousDiv = document.querySelector('.info-node-div');
    if (previousDiv) {
    previousDiv.remove();
    }
        // Obtener las coordenadas del div.vis-tooltip
        var tooltip = document.querySelector('.vis-tooltip');
        var tooltipRect = tooltip.getBoundingClientRect();
        var tooltipX = tooltipRect.left;
        var tooltipY = tooltipRect.top -23;
    
        // Crear el div con la información del nodo
        let div = document.createElement("div");
        div.innerHTML = "Información del nodo:<br>"+ params.nodes[0];
        div.classList.add("info-node-div");
        div.style.cssText = "left:"+tooltipX+"px;top:"+tooltipY+"px;padding:10px;";
        document.body.appendChild(div);
    }
    
  });



  network.on("deselectNode", function (params) {
    if (document.querySelector('.info-node-div')) {
        document.querySelector('.info-node-div').remove();
        }
    
});

network.on("dragEnd", function (params) {
    if (document.querySelector('.info-node-div')) {
        document.querySelector('.info-node-div').remove();
        }
});
  // Oculta el elemento "lottie" cuando se carga la red de nodos
  network.once('afterDrawing', function() {
    const lottie = document.getElementById('lottie');
    lottie.style.display = 'none';
  });






  </script>
</body>
</html>
