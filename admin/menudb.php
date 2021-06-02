<?php
session_start();
$USR = $_SESSION['admin'];

if($USR == null){
    header("location:../admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    
<head><meta charset="gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion de Productos</title>
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="admin_controll.css">
    <style>
        .title {
            text-align: center;
            color:#fa3c00; 
            text-shadow: 1.5px 1px 2px #000;
        } 
        .guar {
            margin: 2% 0 2% 0;
        }
    </style>
</head>
<body>
    <?php require_once('admin_navbar.php')?>
    <br>
    <br>
        <h3 class="title">Gestion de Menu</h3>
        <br>
     <div class="col text-center">
            <a class="btn btn-dark btn-lg" href="panel.php">Atras</a>
        <?php if($change == true){?>
            <a class="btn btn-warning btn-lg" href="#">Concluir</a>
        <p><?php echo $sql;?></p>
        <?php }else{?>
            <a href="crear_plato.php" class="btn btn-default btn btn-dark btn-lg">Crear Plato</a>
            <br>
            <a href="crearguarnicion.php" class="btn btn-default btn btn-dark btn-lg guar">Crear Guarnicion</a>
        <?php }?> 
    </div>
    <br>
    <form class="container">
        <div class="form-group mx-sm-3 mb-2">
            <input type="text" class="form-control" id="search" placeholder="Buscar...">
        </div>
    </form>
    <br>
  
    <section class="container">
    <?php 
         require_once('../z_connect.php');

        echo "
        <div class='table-responsive'>
        <table class='table table-hover'>
                    <thead>
                        <tr class='table-danger'>
                            <th scope='col'>#</th>
                            <th scope='col'>Plato</th>
                            <th scope='col'>Categoría</th>
                            <th scope='col'>Estado</th>
                            <th scope='col'>Precio</th>
                            <th scope='col'>Costo</th>
                            <th scope='col'>Imagen</th>
                            <th scope='col'>Descripcion</th>
                            <th scope='col'>Detalles</th>
                            <th scope='col'>Registro</th>
                            <th scope='col'>Eliminar</th>
                            <th scope='col'>Editar</th>
                        </tr>
                    </thead>";

                    if(isset($_GET['delete'])){
                        $id = $_GET['delete'];
                        $conn->query("DELETE FROM platillos WHERE id_platillo = '$id'");
                    }

                    $sql = "SELECT * FROM platillos ORDER BY id_platillo ASC";
                    $result = $conn-> query($sql) or die ("error en query $sql".mysqli_error());

                    if($result-> num_rows > 0) {
                    
                        while($row = mysqli_fetch_assoc($result)){
                            echo "
                            <tbody>
                            <td>".$row["id_platillo"]."</td>
                            <td class='producto'>".$row["platillo"]."</td>
                            <td>".$row["categoria"]."</td>
                            <td>".$row["estado"]."</td>
                            <td>$".$row["precio"]." MXN</td>
                            <td>$".$row["costo"]." MXN</td>
                            <td><img src='img_menu/".$row["imagen"]."' width='70%'></td>
                            <td>".$row["descripcion"]."</td>
                            <td>".$row["detalle"]."</td>
                            <td>".$row["registro"]."</td>
                            <td><a href='menudb.php?delete=".$row["id_platillo"]."'><i class='fas fa-trash-alt'></i></a></td>
                            <td><a href='crear_plato.php?edit=".$row["id_platillo"]."'><i class='fas fa-edit'></i></a></td>";
                }
                    echo "
                        </tbody>
                    </table>
                </div>";
                }
                else {
                    echo "<div class='alert alert-warning' role='alert'>
                    No hay informacion por el momento.
                          </div>";
                }

                //$connect-> close();
    
    ?>
   
    </section>
    <script type='text/javascript'>
            let search_input = document.getElementById('search')
            
            search_input.addEventListener('keyup',function(e){
                let search_item = e.target.value.toLowerCase();
                let td_item = document.querySelectorAll("table tbody .producto");
                console.log(td_item);
                
                td_item.forEach(function(item){
                    if(item.textContent.toLowerCase().indexOf(search_item)!=-1){
                        item.closest("table tr").style.display = "block";
                    }else{
                        item.closest("table tr").style.display = "none";
                    }
                });
            });
    </script>
    <?php  $connect-> close();?>
</body>
</html>