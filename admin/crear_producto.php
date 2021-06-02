<?php
session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
}

require '../z_connect.php';
//Creación de Producto
if(isset($_POST['create'])){

$sku = $_POST['sku'];
$product = $_POST['producto'];
$brand = $_POST['marca'];
$unit = $_POST['unidad_c'];
$measure = $_POST['medida'];
$price = $_POST['precio'];
$cost = $_POST['costo'];
$extras = $_POST['extras']?? 0;


$sql = "INSERT INTO inventarios (sku, producto, marca, unidad_c, medida, precio, extras, costo) VALUES ('$sku','$product','$brand','$unit','$measure','$price','$extras','$cost');";
$result = mysqli_query($conn, $sql) or die ("error en query $sql".mysqli_error());


if($result){
  echo "Success!";
}else{
  echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
};

mysqli_free_result($result);
mysqli_close($conn);

header('Location:inventariodb.php');

}
//Edición de Producto

$id = 0;
$update = false;

if(isset($_GET['edit'])){

    $id = $_GET['edit'];
    $update = true;
    $query = "SELECT * FROM inventarios WHERE sku = '$id'";
    $result = mysqli_query($conn, $query) or die ("error en query $query".mysqli_error());
   if(count($result)==1){

    $row = $result->fetch_array();
    $sku = $row['sku'];
    $product = $row['producto'];
    $brand = $row['marca'];
    $unit = $row['unidad_c'];
    $measure = $row['medida'];
    $price = $row['precio'];
    $cost = $row['costo'];
    //};
    


    if(isset($_POST['update']) and $_SERVER['REQUEST_METHOD'] == "POST"){
      
      $new_sku = $_POST['sku'];
      $new_product = $_POST['producto'];
      $new_brand = $_POST['marca'];
      $new_unit = $_POST['unidad_c'];
      $new_measure = $_POST['medida'];
      $new_price = $_POST['precio'];
      $new_cost = $_POST['costo'];
    
      $mysql = ("UPDATE inventarios SET sku= '$new_sku', producto= '$new_product', marca= '$new_brand', unidad_c= '$new_unit', medida= '$new_measure', precio= '$new_price', costo= '$new_cost' WHERE sku='$id'");

      $res = mysqli_query($conn, $mysql) or die ("error en query $mysql".mysqli_error());

      if($res){
        echo "Success!";
      }else{
        echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
      };
      
      mysqli_free_result($mysql);
      mysqli_close($conn);

      header('Location:inventariodb.php');
    };

  };

};
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear producto</title>
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="admin_controll.css">
</head>
<style>
.title {
            text-align: center;
            color:#fa3c00; 
            text-shadow: 1.5px 1px 2px #000;
        } 
</style>
<body>
<?php require_once('admin_navbar.php')?>
<br>
<h2 class="text-center title">Nuevo Producto</h2>
<br>
<section class="container">
<form method="POST" enctype="multipart/form-data">
  <input type="hidden" name="id_producto" value="<?php echo $id;?>">
  <div class="form-row">
    <label for="inputAddress2">Nombre de Producto:</label>
    <input type="text" class="form-control" id="inputAddress2" name="producto" value="<?php echo $product ?? "";?>" placeholder="Introduce nombre" require>
  </div>
  <br>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">SKU:</label>
      <input type="text" class="form-control"  name="sku" value="<?php echo $sku??"";?>" id="inputCity" placeholder="000" require>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Marca:</label>
      <input type="text" class="form-control" name="marca" value="<?php echo $brand??"";?>" id="inputZip" placeholder="Marca de Procuto">
    </div>
    <div class="form-group col-md-6">
      <label for="inputCity">Cantidad:</label>
      <input type="number" step="0.01" min="0" max="100000" class="form-control"  name="unidad_c" value="<?php echo $unit??"";?>" id="inputCity" placeholder="00 Gr/Lt" required>
    </div>
    <div class="form-group col-md-2">
    <label for="inputEmail4">Medición:</label>
      <select id="inputState" class="form-control" name="medida">
        <option value="<?php echo $measure??"";?>"><?php echo $measure??"";?></option>
        <option value="mg">mg</option>
        <option value="g">g</option>
        <option value="Kg">Kg</option>
        <option value="ml">ml</option>
        <option value="l">l</option>
        <option value="Kl">Kl</option>
      </select>
    </div>
  </div>

  <br>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Costo de producto:</label>
      <input type="number" step="0.01" min="0" max="100000" class="form-control"  name="costo" value="<?php echo $cost;?>" id="inputCity" placeholder="$00.00" required>
    </div>
    <div class="form-group col-md-4">
    <label for="inputZip">Precio de Venta (Extra):</label>
      <input type="number" step="0.01" min="0" max="100000" class="form-control" name="precio" value="<?php echo $price;?>" id="inputZip" placeholder="$00.00" required>
    </div>
    <div class="form-group col-md-2 text-center" style="display: grid;">
      <label for="extra">Extra</label>
      <input type="checkbox" id="extra" name="extras" value="1" style="transform: scale(2.5);margin-left: auto;margin-right: auto;" >
    </div>
  </div>
  
  <a href="inventariodb.php" class="btn btn-dark">Regresar</a> <!--Cambio Variable GET-->
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
