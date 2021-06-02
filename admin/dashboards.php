<?php
session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
}

require_once('../z_connect.php');

//Ingresos Al Día

$sql_four = "SELECT Date(registro) as fecha, Sum(Costo*cantidad)as total From comandas Where status = 'Pagado' Group by 1 Order by 1" ;
$result = mysqli_query($conn, $sql_four) or die ("error en query $sql_four".mysqli_error());
$DobleY = array();
$DobleX= array();

while($data= mysqli_fetch_row($result)){
  $DobleY[] = $data[1];
  $DobleX[]= $data[0];
  
}

$datos_cuatroY = json_encode($DobleY);
$datos_cuatroX = json_encode($DobleX);

$sql_fours = "SELECT Date(registro) as fecha, Sum(Costo*cantidad)as total From comandas Where status = 'Cocina_Cancelada' Group by 1 Order by 1" ;
$result = mysqli_query($conn, $sql_fours) or die ("error en query $sql_fours".mysqli_error());
$DobleYs = array();
$DobleXs= array();

while($data= mysqli_fetch_row($result)){
  $DobleYs[] = $data[1];
  $DobleXs[]= $data[0];
  
}

//Ingresos por Mesa
$sql_two = "SELECT mesa, Sum(Costo*cantidad )as total FROM comandas Where status = 'Pagado' Group by 1 Order by 1" ;
$result_two = mysqli_query($conn, $sql_two) or die ("error en query $sql_two".mysqli_error());
$barValorY = array();
$barValorX = array();

while($row= mysqli_fetch_row($result_two)){
  $barValorY[] = $row[1];
  $barValorX[]= $row[0];
  
}

$datos_dosY = json_encode($barValorY);
$datos_dosX = json_encode($barValorX);

//Ordenes por categoría
$sql_three = "SELECT categoria, (cantidad*comandas.costo) As total FROM platillos, comandas WHERE platillos.platillo = comandas.platillo";
$result_three = mysqli_query($conn, $sql_three) or die ("error en query $sql_two".mysqli_error());
$catValorY = array();
$catValorX = array();

while($row= mysqli_fetch_row($result_three)){
  $catValorY[] = $row[1];
  $catValorX[]= $row[0];
  
}

$datos_tresY = json_encode($catValorY);
$datos_tresX = json_encode($catValorX);

//Usuarios Al Dia

$datos_cuatroYs = json_encode($DobleYs);
$datos_cuatroXs = json_encode($DobleXs);

$sql_one = "SELECT Date(registro) as fecha, count(usuario)as total From comandas Where status = 'Pagado' Group by 1" ;
$result = mysqli_query($conn, $sql_one) or die ("error en query $sql_one".mysqli_error());
$valoresY = array();
$valoresX= array();

while($ver= mysqli_fetch_row($result)){
  $valoresY[] = $ver[1];
  $valoresX[]= $ver[0];
  
}

$datosY = json_encode($valoresY);
$datosX = json_encode($valoresX);

//Grafica Pie

$sql_six_A = "SELECT count(usuario) as total FROM usuarios";
$result_six_A = mysqli_query($conn, $sql_six_A) or die ("error en query $sql_six_A".mysqli_error());
$result_six_A_object = $result_six_A->fetch_object();

$sql_six_B = "SELECT count(cliente) as total FROM clientes";
$result_six_B = mysqli_query($conn, $sql_six_B) or die ("error en query $sql_six_B".mysqli_error());
$result_six_B_object = $result_six_B->fetch_object();

$intA = (int)$result_six_A_object->total;
$intB = (int)$result_six_B_object->total;

$datos_seisA = json_encode($intA);
$datos_seisB = json_encode($intB);

//Usuarios Por Mesa
$sql_seven = "SELECT mesa, count(usuario) as total FROM comandas Where status = 'Pagado' Group by 1";
$result = mysqli_query($conn, $sql_seven) or die ("error en query $sql_seven".mysqli_error());
$valuesY = array();
$valuesX= array();

while($val= mysqli_fetch_row($result)){
  $valuesY[] = $val[1];
  $valuesX[]= $val[0];
  
}

$datos_sieteY = json_encode($valuesY);
$datos_sieteX = json_encode($valuesX);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Anuncios</title>
    <style>
        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

       .border{
        box-shadow: 5px 10px #0000;
       }
        
        @media only screen and (min-width: 500px){
            
        }
    </style>
</head>
<body>
<?php include_once('admin_navbar.php') ?>

    <section class="container">
        <br>
        <h3 class="title">Dashboard</h3>
        <br>
          
        <div class="col text-center">
            <a class="btn btn-dark btn-lg" href="panel.php">Atras</a>
            <a class="btn btn-dark btn-lg" href="comments.php">Comentarios</a>
        </div>
        <br>
    </section>
    <!--Primera sección-->
    <section class="container">
        <div class="row">
        
          <div class="col-sm-12">
            <div class="panel panel-primary">

                <div class="table-danger">
                    <h5 class="h2 text-center">Graficas de Actividad</h5>
                </div>
                
              <div class="panel panel-body border" >
                  <div class="row">
                    <div class=col-sm-6>
                      <div id="graficaDoble"></div>
                    </div>
                    <div class=col-sm-6>
                      <div id="graficaBarras"></div>
                    </div>
                  </div>              
              </div>
            </div>
          </div>
        </div>
       
    </section>
    <!--Segunda sección-->
    <section class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-primary">
                
              <div class="panel panel-body border" >
                  <div class="row">
                    <div class=col-sm-6>
                      <div id="graficaBarMesa"></div>
                    </div>
                    <div class=col-sm-6>
                      <div id="graficaLineal"></div>
                    </div>
                  </div>              
              </div>
            </div>
          </div>
        </div>
       
    </section>
    <!--Tercera sección-->
    <section class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-primary">
                
              <div class="panel panel-body border" >
                  <div class="row">
                    <div class=col-sm-6>
                      <div id="graficaPie"></div>
                    </div>
                    <div class=col-sm-6>
                      <div id="graficaCategorias"></div>
                    </div>
                  </div>              
              </div>
            </div>
          </div>
        </div>
         
     </section>
</body>
</html>

<script src="graficas.js" type="text/javascript"></script>
<script type="text/javascript">

//Usuarios Al Dia
datosX = crearGrafica('<?php echo $datosX ?>');
datosY = crearGrafica('<?php echo $datosY ?>');
//fechas = datosX.map(String);

var trace1 = {
  x: datosX,
  y: datosY,
  type: 'scatter',
  marker: {
      color: 'rgb(242, 95, 151)', 
    }
};

var data = [trace1];

var layout = {
  title: 'Usuarios al día',
  font:{
    family: 'Raleway, sans-serif'
  },
  xaxis: {
    title: "Días",
    font:{
    family: 'Raleway, sans-serif'
    },
    tickangle: -45
  },
  yaxis: {
    title: "Ingresos",
    font:{
    family: 'Raleway, sans-serif'
    },
    zeroline: false,
    gridwidth: 2
  },
  bargap :0.05
};

Plotly.newPlot('graficaLineal', data, layout);

//Ingresos por Mesa

datos_dosX = crearGraficaBar('<?php echo $datos_dosX ?>');
datos_dosY = crearGraficaBar('<?php echo $datos_dosY ?>');

var data_dos = [
  {
    x: datos_dosX,
    y: datos_dosY,
    type: 'bar',
    marker: {
      color: 'rgb(113, 202, 213)',
    }
  }
];

var layout_dos = {
  title: 'Ingresos por mesa',
  font:{
    family: 'Raleway, sans-serif'
  },
  xaxis: {
    title: "Mesas",
    font:{
    family: 'Raleway, sans-serif'
    },
    tickangle: -45
  },
  yaxis: {
    title: "Ingresos",
    font:{
    family: 'Raleway, sans-serif'
    },
    zeroline: false,
    gridwidth: 2
  },
  bargap :0.05
};

Plotly.newPlot('graficaBarras', data_dos, layout_dos );
	

//Ordenes por categoría

datos_tresX = crearGraficaBar('<?php echo $datos_tresX ?>');
datos_tresY = crearGraficaBar('<?php echo $datos_tresY ?>');

var data_tres = [
  {
    x: datos_tresX,
    y: datos_tresY,
    type: 'bar',
    marker: {
      color: 'rgb(113, 202, 213)',
    }
  }
];

var layout_tres = {
  title: 'Total Ordenadas Por Categorías',
  font:{
    family: 'Raleway, sans-serif'
  },
  xaxis: {
    title: "Categorías",
    font:{
    family: 'Raleway, sans-serif'
    },
    tickangle: -45
  },
  yaxis: {
    title: "Ordenes",
    font:{
    family: 'Raleway, sans-serif'
    },
    zeroline: false,
    gridwidth: 2
  },
  bargap :0.05
};

Plotly.newPlot('graficaCategorias', data_tres, layout_tres);

//Ingresos Al Día

datos_cuatroX = crearGrafica('<?php echo $datos_cuatroX ?>');
datos_cuatroY = crearGrafica('<?php echo $datos_cuatroY ?>');

datos_cuatroXs = crearGrafica('<?php echo $datos_cuatroXs ?>');
datos_cuatroYs = crearGrafica('<?php echo $datos_cuatroYs ?>');

var Pagadas = {
  x: datos_cuatroX,
  y: datos_cuatroY,
  type: 'scatter',
  mode: 'lines',
  name: 'Pagadas',
  marker: {
      color: 'rgb(242, 95, 151)', 
    }
};

var Canceladas = {
  x: datos_cuatroXs,
  y: datos_cuatroYs,
  type: 'scatter',
  mode: 'lines+markers',
  name: 'Canceladas',
  marker: {
      color: 'rgb(242, 95, 151)', 
    }
};

var data_doble = [Pagadas,Canceladas];

var layout = {
  title: 'Ingresos al día',
  font:{
    family: 'Raleway, sans-serif'
  },
  xaxis: {
    title: "Días",
    font:{
    family: 'Raleway, sans-serif'
    },
    tickangle: -45
  },
  yaxis: {
    title: "Ingresos",
    font:{
    family: 'Raleway, sans-serif'
    },
    zeroline: false,
    gridwidth: 2
  },
  bargap :0.05
};

Plotly.newPlot('graficaDoble', data_doble, layout);

//Grafica Pie

datos_seisA  = crearGraficaPie('<?php echo $datos_seisA ?>');
datos_seisB  = crearGraficaPie('<?php echo $datos_seisB ?>');

var data_seis = [{
  values: [datos_seisA , datos_seisB],
  labels: ['Usuarios', 'Clientes'],
  type: 'pie'
}];

var layout_seis = {
  title: 'Distribución Usuarios-Clientes ',
  font:{
    family: 'Raleway, sans-serif'
  },
  height: 400,
  width: 500
};

Plotly.newPlot('graficaPie', data_seis, layout_seis);

//Usuarios Por Mesa

datos_sieteX = crearGraficaBar('<?php echo $datos_sieteX ?>');
datos_sieteY  = crearGraficaBar('<?php echo $datos_sieteY ?>');

var data_siete = [
  {
    x: datos_sieteX,
    y: datos_sieteY,
    type: 'bar',
    marker: {
      color: 'rgb(113, 202, 213)',
    }
  }
];

var layout_siete = {
  title: 'Usuarios Por Mesa',
  font:{
    family: 'Raleway, sans-serif'
  },
  xaxis: {
    title: "Mesas",
    font:{
    family: 'Raleway, sans-serif'
    },
    tickangle: -45
  },
  yaxis: {
    title: "Ususarios",
    font:{
    family: 'Raleway, sans-serif'
    },
    zeroline: false,
    gridwidth: 2
  },
  bargap :0.05
};

Plotly.newPlot('graficaBarMesa', data_siete, layout_siete );

</script>