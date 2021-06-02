<?php
session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
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
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }
        .sesion {
            text-align: center;
            color: blue; 
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
  <i class="fas fa-concierge-bell"></i>
  </div>
  <div class="card-body">
    <h5 class="card-title">Gestión de Comandas</h5>
    <p class="card-text">Optimice tiempos en su operación y revise las comandas que los comensales van generando. Con un click podrá controlar lo que entra a cocina.</p>
    <a href="gestion_comandas.php" class="btn btn-dark">Revisar</a>
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