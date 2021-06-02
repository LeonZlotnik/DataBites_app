<?php
session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
}

require '../z_connect.php';
//Creación de Producto
if(isset($_POST['create'])){

$ingrediente = $_POST['ingrediente'];
$valor = $_POST['valor'];

$sql = "INSERT INTO guarnicones ( ingrediente, valor) VALUES ('$ingrediente','$valor');";
$result = mysqli_query($conn, $sql) or die ("error en query $sql".mysqli_error());

if($result){
  echo "Success!";
}else{
  echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
};

mysqli_free_result($result);
mysqli_close($conn);

header('Location:menudb.php');

}
//Edición de Producto

$id = 0;
$update = false;

if(isset($_GET['edit'])){

    $id = $_GET['edit'];
    $update = true;
    $query = "SELECT * FROM guarnicones WHERE id_guarnicion = '$id'";
    $result = mysqli_query($conn, $query) or die ("error en query $query".mysqli_error());
   if(count($result)==1){

    $row = $result->fetch_array();
    $ingrediente = $_POST['ingrediente'];
    $valor = $_POST['valor'];
    //};


    if(isset($_POST['update']) and $_SERVER['REQUEST_METHOD'] == "POST"){
      
      $new_ingrediente = $_POST['ingrediente'];
      $new_valor = $_POST['valor'];
    
      $mysql = ("UPDATE guarnicones SET ingrediente= '$new_ingrediente', valor= '$new_valor' WHERE platillo='$id'");

      $res = mysqli_query($conn, $mysql) or die ("error en query $mysql".mysqli_error());

      if($res){
        echo "Success!";
      }else{
        echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
      };
      
      mysqli_free_result($mysql);
      mysqli_close($conn);

      header('Location:menudb.php');
    };

  };

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear guarnición</title>
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="admin_controll.css">
    <style>
        .title {
            text-align: center;
            color:#fa3c00; 
            text-shadow: 1.5px 1px 2px #000;
        } 
    </style>
</head>
<body>
<?php require_once('admin_navbar.php')?>
<br>
<h2 class="text-center title">Nombre de Guarnición</h2>
<br>
<section class="container">
<form method="POST" enctype="multipart/form-data">
  <input type="hidden" name="id_guarnicion" value="<?php echo $id;?>">
  <div class="form-row">
    <label for="inputAddress2">Nombre de guarnición:</label>
    <input type="text" class="form-control" id="inputAddress2" name="ingrediente" value="<?php echo $ingrediente ?? "";?>" placeholder="Introduce nombre" require>
  </div>
  <br>

  <div class="form-row">
    <div class="form-group col-12">
      <label for="inputCity">Precio:</label>
      <input type="number" step="0.01" min="0" max="100000" class="form-control"  name="valor" value="<?php echo $price;?>" id="inputCity" placeholder="$00.00">
    </div>
  </div>
  
  <a href="menudb.php" class="btn btn-dark">Regresar</a> <!--Cambio Variable GET-->
  <?php if($update == true){?>
  <input class="btn btn-warning" type="submit" name="update" value="Editar" id="gridCheck">
  <p><?php echo $mysql;?></p>
  <?php }else{?>
  <input class="btn btn-dark" type="submit" name="create" value="Crear" id="gridCheck">
  <?php }?>
</form>
</section>
<br>
</body>
</html>