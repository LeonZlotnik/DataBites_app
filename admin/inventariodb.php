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
    <title>Gestión de Productos</title>
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
    <br>
        <h3 class="title">Gestion de Inventario</h3>
        <br>
     <div class="col text-center">
            <a class="btn btn-dark btn-lg" href="panel.php">Atras</a>
        <?php if($change == true){?>
            <a class="btn btn-warning btn-lg" href="#">Concluir</a>
        <p><?php echo $sql;?></p>
        <?php }else{?>
            <a href="crear_producto.php" class="btn btn-default btn btn-dark btn-lg">Introducir Producto</a>
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
         require '../z_connect.php';

        echo "
        <div class='table-responsive'>
        <table class='table table-hover'>
                    <thead>
                        <tr class='table-danger'>
                            <th scope='col'>SKU</th>
                            <th scope='col'>Producto</th>
                            <th scope='col'>Marca</th>
                            <th scope='col'>Cantidad</th>
                            <th scope='col'>Unidades</th>
                            <th scope='col'>Precio de Venta</th>
                            <th scope='col'>Costo de Producto</th>
                            <th scope='col'>Registro</th>
                            <th scope='col'>Eliminar</th>
                            <th scope='col'>Editar</th>
                        </tr>
                    </thead>";

                    if(isset($_GET['delete'])){
                        $id = $_GET['delete'];
                        $conn->query("DELETE FROM inventarios WHERE sku= '$id'");
                    }

                    $sql = "SELECT * FROM inventarios ORDER BY sku ASC";
                    $result = $conn-> query($sql) or die ("error en query $sql".mysqli_error());

                    if($result-> num_rows > 0) {
                    
                        while($row = mysqli_fetch_assoc($result)){
                            echo "
                            <tbody>
                            <td>".$row["sku"]."</td>
                            <td class='producto'>".$row["producto"]."</td>
                            <td>".$row["marca"]."</td>
                            <td>".$row["unidad_c"]."</td>
                            <td>".$row["medida"]."</td>
                            <td>$".$row["precio"]." MXN</td>
                            <td>$".$row["costo"]." MXN</td>
                            <td>".$row["registro"]."</td>
                            <td><a href='inventariodb.php?delete=".$row["sku"]."'><i class='fas fa-trash-alt'></i></a></td>
                            <td><a href='crear_producto.php?edit=".$row["sku"]."'><i class='fas fa-edit'></i></a></td>";
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