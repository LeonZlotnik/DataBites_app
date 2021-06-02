<?php
    session_start();
    $USR = $_SESSION['usuario'];

    if($USR == null){
        header("location:index.php");
    }

    if(isset($_GET['total'])){
        (int)$id = $_GET['total'];
        $Total = (int)$id;
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias!</title>
</head>
<body>
<?php
require_once("nav_bar.php");
?>
<br>
<section class="container">
<div class="card text-center">
  <div class="card-header">
    ¡Cuenta Completada!
  </div>
  <div class="card-body">
    <h5 class="card-title">Gracias <?php echo $USR ?>, esperamos verlo pronto</h5>
    <p class="card-text">El total de su cuenta fue de ($<?php echo $Total ?> mxn)</p>
    
    <?php
    session_start();
    if(isset($_SESSION['usuario'])){
        echo "<a href='salir.php?salir' class='btn btn-info btn-lg btn-block'>Terminar</a>";
    }
    ?>
  </div>
  <div class="card-footer text-muted">
    Solicite al mesero su ticket porfavor. 
  </div>
</div>
</section>
<br>
<?php require_once('footer.html')?>
</body>
</html>
