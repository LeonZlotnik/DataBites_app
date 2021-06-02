<?php
session_start();
$USR = $_SESSION['admin'];
$T = $_SESSION['type'];
if($USR == null){
    header("location:../admin.php");
}

if($T == 'piso'){
  header("location:panel_2.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <style>
        .title {
            text-align: center;
            color:#fa3c00; 
            text-shadow: 1.5px 1px 2px #000;
        }
        .sesion {
            text-align: center;
            color: #fa3c00; 
            text-shadow: 1px 1px 1px #000;
        }
    </style>
</head>
<body>
<?php require_once('admin_navbar.php')?>

<div class="container">
    <br>
    <h2 class="text-center title">Panel de Control</h2>
    <h6 class="text-center sesion">Admin: <?php echo $_SESSION['admin'];?></h6>
    <br>
<div class="card">
  <div class="card-header">
  <i class="fas fa-users-cog"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Gestión de Administradores</h5>
    <p class="card-text">Mantenga el control de su negocio y de quienes lo operan para una mejor gestión.</p>
    <a href="contol_admin.php" class="btn btn-dark">Revisar</a>
  </div>
</div>
<br>
<div class="card">
  <div class="card-header">
  <i class="fas fa-street-view"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Control de Clientes</h5>
    <p class="card-text">Procure una buena relación con sus clientes más allegados y mejore el contacto con ellos.</p>
    <a href="control_clientes.php" class="btn btn-dark">Revisar</a>
  </div>
</div>
<br>
<div class="card">
  <div class="card-header">
  <i class="fas fa-utensils"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Gestión de Menu</h5>
    <p class="card-text">Crear, editar y borrar los productos a su conveniencia, con el fin de facilitarle la gestión del menu. Procure ser lo más especifico en las descripciones, imagenes mayores a 30 KB posiblemente no cargarán.</p>
    <a href="menudb.php" class="btn btn-dark">Revisar</a>
  </div>
</div>
<br>
<div class="card">
  <div class="card-header">
  <i class="fas fa-warehouse"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Gestión de Inventario</h5>
    <p class="card-text">Suba los prooductos que requiere para elaborar los platillos. De esta forma será más facil saber cuanto del inventario se esta consumiendo al día.</p>
    <a href="inventariodb.php" class="btn btn-dark">Revisar</a>
  </div>
</div>
<br>
<div class="card">
  <div class="card-header">
  <i class="fas fa-concierge-bell"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Gestión de Comandas</h5>
    <p class="card-text">Optimice tiempos en su operación y revise las comandas que los comensales van generando. Con un click podrá controlar lo que entra a cocina.</p>
    <a href="gestion_comandas.php" class="btn btn-dark">Revisar</a>
  </div>
</div>
<br>
<div class="card">
  <div class="card-header">
  <i class="fas fa-bullhorn"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Centro de Anucios</h5>
    <p class="card-text">Aproveche al máximo la atención que le brindan sus consumidores para informarles de promos.</p>
    <a href="centro_ads.php" class="btn btn-dark">Revisar</a>
  </div>
  </div>
  <br>
  <div class="card">
  <div class="card-header">
  <i class="fas fa-funnel-dollar"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Gestión de Ventas</h5>
    <p class="card-text">Corrobore el estatus de las comandas, a manera de tener la actividad más clara. Podrá también corregir la cuenta de los comensales, en caso de que haya algun mal entendido.</p>
    <a href="gestion_ventas.php" class="btn btn-dark">Revisar</a>
  </div>
  </div>
  <br>
  <div class="card">
  <div class="card-header">
  <i class="fas fa-chart-pie"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Visualización de Data</h5>
    <p class="card-text">Aumente su conocimiento del día a día del restaurante, con información en tiempo real sobre la operacion y las oportunidades que existen para incrementar margenes.</p>
    <a href="dashboards.php" class="btn btn-dark">Revisar</a>
  </div>
</div>
<br>

<?php
 session_start();
 if(isset($_SESSION['admin'])){
   echo "<a href='logout.php?salir' class='btn btn-danger btn-lg btn-block'>Salir</a>";
 }
?>
</div>
<br>

</div>
<br>
    <?php require_once('../footer.html')?>
</body>

<script>

  var b = localStorage.getItem(a);
  alert("Asistencia Requerida" + b);
  var resetValue = 0;
  localStorage.setItem(b, resetValue);
</script>
</html>

