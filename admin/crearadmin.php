<?php
session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
}
    if(isset($_POST['insert'])){
        require '../z_connect.php';
        
        $user = $_POST['usuario'];
        $pw = $_POST['password'];
        $type = $_POST['acceso'];

        $sql = "INSERT INTO administradores (usuario, password, acceso) VALUES ('$user', '$pw','$type');";
        $result = mysqli_query($conn, $sql) or die ("error en query $sql".mysqli_error());

        if($result){
            echo "Success!";
          }else{
            echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
          };
          
          mysqli_free_result($result);
          mysqli_close($conn);
          
          header('Location:contol_admin.php');

    }

?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="euc-jp">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creacion de admin</title>
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
<h2 class="text-center title">Crear Administrador</h2>
<br>
<section class="container">
<form method="POST" enctype="multipart/form-data">
  <div class="form-row">
    
    <div class="form-group col-md-6">
      <label for="inputPassword4">Usuario:</label>
      <input type="text" name="usuario"  class="form-control" id="inputPassword4" placeholder="Inrtoduce apellido" required>
    </div>
  </div>
  <div class="form-row">
    <label for="inputAddress2">Contraseña:</label>
    <input type="password" name="password"  class="form-control" id="inputAddress2" placeholder="Inrtoduce contraseña" required>
  </div>
  <br>
  <div class="form-row">
  <select name="acceso" class="custom-select" id="inputGroupSelect01" required>
            <option value="null">--</option>
            <option value="gerente">Gerencia</option>
            <option value="piso">Personal</option>
        </select>
  </div>
  <br>
  
  <a href="contol_admin.php" class="btn btn-dark">Regresar</a>
  <input type="submit" name="insert" class="btn btn-dark" value="Crear">
</form>
</section>
<br>
</body>
</html>