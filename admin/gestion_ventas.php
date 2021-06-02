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
    <title>Control de Clientes</title>
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
        <h3 class="title">Cuentas Por Pagar</h3>
    <br>
    <form class="container">
        <div class="form-group mx-sm-3 mb-2">
            <input type="text" class="form-control" id="search" placeholder="Buscar...">
        </div>
    </form>
    <br>
    <div class="col text-center">
        <a class="btn btn-dark btn-lg" href="panel.php">Atras</a>
        <a href="gestion_ingresos.php" class="btn btn-default btn btn-dark btn-lg">Finales</a>
    </div>
    <br>

    <section class="container">
    <?php 
         require_once('../z_connect.php');

        echo "
        <div class='table-responsive'>
        <table class='table table-hover'>
                    <thead>
                        <tr class='table-danger'>
                            <th scope='col'>Usuario</th>
                            <th scope='col'>No. Mesa</th>
                            <th scope='col'>Plato</th>
                            <th scope='col'>Costo</th>
                            <th scope='col'>Cantidad</th>
                            <th scope='col'>Especificaciones</th>
                            <th scope='col'>Registro</th>
                            <th scope='col'>Guarniciones</th>
                            <th scope='col'>Extras</th>
                            <th scope='col'>Eliminar</th>
                        </tr>
                    </thead>";

                    if(isset($_GET['delete_1'])){
                        $id = $_GET['delete_1'];
                        $conn->query("UPDATE comandas SET status = 'Cuenta_Cancelada' WHERE id_comanda = '$id' AND status = 'Cuenta'");
                    }

                    $totalExtra =0;
                    $subtotalFinal =0;  

                    $sql = "SELECT *, (costo*cantidad) AS total FROM comandas WHERE status = 'Cuenta'";
                    $result = $conn-> query($sql) or die ("error en query $sql".mysqli_error());

                    if($result-> num_rows > 0) {
                    
                        while($row = mysqli_fetch_assoc($result)){
                            if($row["extras"]!=null) {
                                $sqlExtras = "SELECT sum(precio) total from inventarios where producto in ('" . $row["extras"] . "')";
                                $resultExtra = $conn->query($sqlExtras) or die ("error en query $sqlExtras" . mysqli_error());
                                if ($resultExtra->num_rows > 0) {
                                    while ($rowExtra = mysqli_fetch_assoc($resultExtra)) {
                                        $totalExtra = $rowExtra["total"];
                                    }
                                }
                            }
                            else{
                                $totalExtra =0;
                            }
                            if($row["guarniciones"]!=null){
                                $sqlGuarniciones="SELECT sum(valor) total from guarnicones where ingrediente in ('".$row["guarniciones"]."')";
                                $resultGuarniciones = $conn-> query($sqlGuarniciones) or die ("error en query $sqlGuarniciones".mysqli_error());
                                if($resultGuarniciones->num_rows>0){
                                    while($rowGuarnicion = mysqli_fetch_assoc($resultGuarniciones)) {
                                        $totalGuanicion = $rowGuarnicion["total"];
                                    }
                                }
                            }
                            else{
                                $totalGuanicion = 0;
                            }
                            $precioTotal = $row["costo"] + $totalExtra + $totalGuanicion;
                            $final += $precioTotal;
                            echo "
                            <tbody>
                            <th scope='row' class='user'>".$row["usuario"]."</th>
                            <td>#".$row["mesa"]."</td>
                            <td>".$row["platillo"]."</td>
                            <td>$".$precioTotal."</td>
                            <td>".$row["cantidad"]."</td>
                            <td>".$row["specs"]."</td>
                            <td>".$row["size"]."</td>
                            <td>".$row["guarniciones"]."</td>
                            <td>".$row["extras"]."</td>
                            <td>".$row["registro"]."</td>
                            <td><a href='gestion_ventas.php?delete_1=".$row["id_comanda"]."'><i class='fas fa-trash-alt'></i></a></td>";
                }

                    echo "
                        </tbody>
                    </table>
                </div>";
                }
                else {
                    echo "<div class='alert alert-warning' role='alert'>
                    No hay información por el momento.
                          </div>";
                }
    
    ?>
    </section>
    </section>
    <script type='text/javascript'>
            let search_input = document.getElementById('search')
            
            search_input.addEventListener('keyup',function(e){
                let search_item = e.target.value.toLowerCase();
                let td_item = document.querySelectorAll("table tbody .user");
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

