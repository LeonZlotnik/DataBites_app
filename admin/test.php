<?php

session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
}


//Creación de Producto
require '../z_connect.php';
if (isset($_POST['create'])){

  $target = "/Applications/MAMP/htdocs/PHP-Python/DataBites_app/admin/img_menu/".$_FILES['imagen']['name'];

  $dish = $_POST['platillo'];
  $category = $_POST['categoria'];
  $status = $_POST['estado'];
  $price = $_POST['precio'];
  $cost = $_POST['costo'];
  $image = $_FILES['imagen']['name'];
  $desc = $_POST['descripcion'];
  $ext = $_POST['detalle'];
  $guarniciones = implode(", ", $_POST['guarniciones']);
  $extras = implode(", ", $_POST['extras']);

  $sql = "INSERT INTO platillos (platillo, categoria, estado, precio, costo, imagen, descripcion, detalle, guarniciones, extras) VALUES ('$dish','$category','$status','$price', '$cost','$image','$desc','$ext','$guarniciones','$extras');";
  $result = mysqli_query($conn, $sql) or die ("error en query $sql" . mysqli_error());


  if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)){
    echo "Success";
  } else {
    echo "<script>console.log('Error de carga')</script>";
  }

  if ($result) {
    echo "Success!";
  } else {
    echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
  };

  mysqli_free_result($result);
  mysqli_close($conn);

  header('Location:menudb.php');

}
//Edición de Producto

$id = 0;
$update = false;

if (isset($_GET['edit'])) {
  require '../z_connect.php';

  $id = $_GET['edit'];
  $update = true;
  $query = "SELECT * FROM platillos WHERE id_platillo = '$id'";
  $result = mysqli_query($conn, $query) or die ("error en query $query" . mysqli_error());
  if (count($result) == 1) {

    $row = $result->fetch_array();
    $dish = $row ['platillo'];
    $category = $row ['categoria'];
    $status = $row ['estado'];
    $price = $row ['precio'];
    $cost = $row ['costo'];
    $image = $row ['imagen']['name'];
    $desc = $row ['descripcion'];
    $ext = $row ['detalle'];
    //};

    if (isset($_POST['update']) and $_SERVER['REQUEST_METHOD'] == "POST") {

      $new_target = "/Applications/MAMP/htdocs/PHP-Python/DataBites_app/admin/img_menu/".$_FILES['imagen']['name'];

      $new_dish = $_POST['platillo'];
      $new_category = $_POST['categoria'];
      $new_status = $_POST['estado'];
      $new_price = $_POST['precio'];
      $new_cost = $_POST['costo'];
      $new_image = empty($_FILES['imagen']['name']) ? $row['imagen'] : $_FILES['imagen']['name'];
      $new_desc = $_POST['descripcion'];
      $new_ext = $_POST['detalle'];

      $mysql = ("UPDATE platillos SET platillo= '$new_dish', categoria= '$new_category', estado= '$new_status', precio= '$new_price', costo= '$new_cost', imagen= '$new_image', descripcion= '$new_desc', detalle= '$new_ext' WHERE id_platillo='$id'");

      $res = mysqli_query($conn, $mysql) or die ("error en query $mysql" . mysqli_error());

      if (move_uploaded_file($_FILES['imagen']['tmp_name'], $new_target)) {
        echo "Success";
      } else {
        echo "<script>console.log('Error de carga')</script>";
      }

      if ($res) {
        echo "Success!";
      } else {
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
    <style>
    @import url('https://fonts.googleapis.com/css?family=Pirata+One|Rubik:900');


    h4.titulo {
        font-weight: bolder;
    }

    input[type="checkbox"] {

    margin-left: 19px;
    margin-top: 6px;
    }

    .checkbox {
    margin-bottom: 14px
    }
    #error{
      display: none;
    }

    .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        } 
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Plato</title>
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="admin_controll.css">
</head>

<body>
    <?php require_once('admin_navbar.php') ?>
    <br>
    <h2 class="text-center title">Crear Plato</h2>
    <br>
    <section class="container">
        <form method="POST" id="form" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
            <!--Sección Formulario-->
            <div class="form-row">
                <label for="inputAddress2">Nombre del Plato:</label>
                <input type="text" class="form-control" id="inputAddress2" name="platillo" value="<?php echo $dish ?>" placeholder="Introduce nombre" required>
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Categoría:</label>
                    <select id="inputState" class="form-control" name="categoria" required>
                        <option><?php echo $category; ?></option>
                        <option value="bebidas">Bebidas</option>
                        <option value="entradas">Entradas</option>
                        <option value="platos">Platillos</option>
                        <option value="especialidades">Especialidades</option>
                        <option value="postres">Postres</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Estado:</label>
                    <select id="inputState" class="form-control" name="estado" required>
                        <option><?php echo $status; ?></option>
                        <option value="Existente">Existente</option>
                        <option value="Agotado">Agotado</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">Precio Venta:</label>
                    <input type="number" step="0.01" min="0" max="100000" class="form-control" name="precio" value="<?php echo $price; ?>" id="precio" placeholder="$00.00" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip">Costo:</label>
                    <input type="number" step="0.01" min="0" max="100000" class="form-control" name="costo" value="<?php echo $cost; ?>" id="costo" placeholder="$00.00" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip">Imagen:</label>
                    <input type="file" class="form-control" name="imagen" value="<?php echo $image; ?>"
                        id="inputZip">
                </div>
            </div>

            <?php if ($update == true) { ?>
            <br>
            <label for="inputZip">Imagen Cargada:</label>
            <div class='card' style='width: 18rem;'>
                <img class='card-img-top' <?php echo "src='img_menu/" . $row['imagen'] . "'"; ?> 
                    alt='Imagen de Producto'>
            </div>
            <br>
            <?php }; ?>


            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descripción</label>
                <textarea required class="form-control" id="exampleFormControlTextarea1" name="descripcion"
                    rows="3"><?php echo $desc; ?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Especificaciones</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="detalle"
                    rows="3"><?php echo $ext ?></textarea>
            </div>
            <div class="form-group">
            </div>
            <!--Sección Guarniciones-->
            <div class="form-row">
                <div class="col-md-12">
                    <h4 class="titulo">
                        Guarniciones
                    </h4>
                  <div class="form-group mx-sm-1 mb-2">
                      <input type="text" class="form-control" id="search" placeholder="Buscar...">
                  </div>
              <br>
                </div>
                
                <?php

            $mysql = ("SELECT * FROM guarnicones");

            $res = mysqli_query($conn, $mysql) or die ("error en query $mysql".mysqli_error());

            if($res->num_rows > 0){
              $i=0;
              while ($guarnicion = $res->fetch_assoc()) {
          ?>
                <div class="checkbox col-3">
                  <div class="producto">
                    <label for="guarnicion<?php echo++$i;?>"><?php echo "$".$guarnicion["valor"]." ".$guarnicion["ingrediente"]; ?></label>
                    <input type="checkbox" id="guarnicion<?php echo$i;?>" name="guarniciones[]" value="<?php echo $guarnicion["id_guarnicion"];?>">

                  </div>
                </div>
                <?php
              }
            }
          ?>
            </div>
            <hr>
            <!--Sección Inventarios-->
            <div class="form-row" style="margin-top:10px;">
                <div class="col-md-12" style="display: grid;">
                    <h4 class="titulo">
                        Extras
                    </h4>

                </div>
                <?php

            $mysql = ("SELECT * FROM inventarios WHERE extras = 1");

            $res = mysqli_query($conn, $mysql) or die ("error en query $mysql".mysqli_error());

            if($res->num_rows > 0){
              $j=0;
              while ($extra = $res->fetch_assoc()) {
          ?>
                <div class="checkbox col-3">
                  <div id="extra">
                    <label id="<?php echo $extra["producto"];?>" for="extra<?php echo++$j;?>">
                        <?php echo  "$".$extra["precio"] . " " . $extra["producto"]; ?></label>
                    <input type="checkbox" id="extra<?php echo$j;?>" style="" name="extras[]"
                        value="<?php echo $extra["id_inventario"];?>">
                  </div>
                </div>
                <?php
              }
            }
          ?>
            </div>
            <hr>
            <div class="alert alert-warning" id="error"></div>
            <a href="menudb.php" class="btn btn-info">Regresar</a>
            <!--Cambio Variable GET-->
            <?php if ($update == true) { ?>
            <input class="btn btn-warning" type="submit" name="update" value="Editar" id="gridCheck">
            <?php } else { ?>
            <input class="btn btn-info" type="submit" name="create" value="Crear" id="gridCheck">
            <?php } ?>
        </form>
    </section>
    <br>
    <script type='text/javascript'>
            let search_input = document.getElementById('search')
            
            search_input.addEventListener('keyup',function(e){
                let search_item = e.target.value.toLowerCase();
                let div_item = document.querySelectorAll("div .producto");
                console.log(search_item);
                
                div_item.forEach(function(item){
                    if(item.textContent.toLowerCase().indexOf(search_item)!=-1){
                      item.closest("div").style.display = "block";
                    }else{
                      item.closest("div").style.display = "none";
                    }
                });
            });

/*const precio = document.getElementById('precio')
const costo = document.getElementById('costo')
const form = document.getElementById('form')
const error = document.getElementById('error')

form.addEventListener('submit', (e) => {
  let messages = []
  if (precio.value <= costo.value) {
    messages.push('¡Este plato no generá lucro! Favor de revisar');
  }
   if (messages.length > 0) {
    e.preventDefault()
    error.innerText = messages.join(', ')
    error.style.display = 'block';
  }
})*/
    </script>
</body>

</html>
