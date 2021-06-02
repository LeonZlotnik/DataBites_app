<?php
session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
}

  if(isset($_POST['insert'])){
      require '../z_connect.php';

$target = "/home/z71akgibyp47/public_html/admin/anuncios/".basename($_FILES['imagen']['name']);

$name = $_POST['anuncio'];
$url = $_POST['link'];
$image = $_FILES['imagen']['name'];
$number = $_POST['numero'];
$status = $_POST['status'];

  $sql = "INSERT INTO anuncios (anuncio, link, imagen, numero, status) VALUES ('$name','$url','$image','$number','$status');";
  $result = mysqli_query($conn, $sql) or die ("error en query $sql".mysqli_error());

  if(move_uploaded_file($_FILES['imagen']['tmp_name'], $target)){
    echo "Success";
  }else{
    echo "<script>console.log('Error de carga')</script>";
  }

  if($result){
    echo "Success!";
  }else{
    echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
  };

  mysqli_free_result($result);
  mysqli_close($conn);
  
  header('Location:centro_ads.php');

};

?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
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
<h2 class="text-center title">Crear Anuncio</h2>
<br>
<section class="container">
<form method="POST" enctype="multipart/form-data">
  <div class="form-row">
    
    <div class="form-group col-md-6">
      <label for="inputPassword4">Nombre de Anuncio:</label>
      <input type="text" name="anuncio"  class="form-control" id="inputPassword4" placeholder="Inrtoduce apellido" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">URL Destino:</label>
      <input type="text" name="link"  class="form-control" id="inputPassword4" placeholder="Inrtoduce URL" required>
    </div>
  </div>
  <div class="form-group col-md-2">
      <label for="inputZip">Imagen:</label>
      <input type="file" class="form-control" name="imagen" value="<?php echo $images;?>" id="inputZip" required>
    </div>
  <div class="form-row">
  <label for="inputPassword4">Posici¨®n:</label>
  <select name="numero" class="custom-select" id="inputGroupSelect01" required>
            <option selected>--</option>
            <option value="First slide">Primera</option>
            <option value="Second slide">Segunda</option>
            <option value="Third slide">Tercera</option>
        </select>
  </div>
  <input type="hidden" name="status" value="Detenido" class="form-control">
  <br>
  
  <a href="centro_ads.php" class="btn btn-dark">Regresar</a>
  <input type="submit" name="insert" class="btn btn-dark" value="Crear">
</form>
</section>
<br>
</body>
</html>