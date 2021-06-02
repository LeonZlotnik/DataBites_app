<?php
    session_start();
    $USR = $_SESSION['usuario'];

    if($USR == null){
        header("location:index.php");
    }

if(isset($_POST['ordenar'])){
    require_once('z_connect.php');
        
    $mysql = "UPDATE comandas SET status = 'Cocina' WHERE usuario ='$USR' AND DATE(registro) = CURDATE() AND status = 'Comanda'";
    $res = mysqli_query($conn, $mysql) or die ("error en query $mysql".mysqli_error());
    
    if($res){
        echo "<script> alert('Gracias por realizar tu orden por este medio, comenzaremos a trabajar en tu comanda enseguida') </script>";

          header('Location:comanda.php?orden="Exitosa"');
      }else{
        $error = "<div class='alert alert-danger' role='alert'>
                Lo sentimos hubo un error, verifique que su session siga activa. 
                </div>";
      };
      
      mysqli_close($conn);
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comanda</title>
    <style>
        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

        .comanda{
            position:fixed; bottom:40px; right:20px;
            transform: translateX(-50%);
            background: linear-gradient(to top, #7DB085, #E6F5DD);
            width: 50px;
            height: 50px;
            line-height: 55px;
            font-size: 22px;
            text-align: center;
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
            z-index: 5;
        }
    
        .comanda a{
            color: white;
            position: relative; top: 1px;
        }
        #total{
            position:fixed; bottom:35px; left:20px;
            /*color: 16327F;*/
        }
        #hidden{
            display: none;
        }
    </style>
</head>
<body>
<?php include_once('nav_bar.php') ?>

    <div class="comanda">
        <a href="cuenta.php"><i class="fas fa-dollar-sign"></i></a>
    </div>

    <section class="container">

    <br>
        <h3 class="title">Comanda</h3>
    <br>

    <?php 
         require_once('z_connect.php');

        echo "
        <div class='table-responsive'>
        <table class='table table-hover'>
                    <thead>
                        <tr class='table-info'>
                            <th scope='col'>Usuario</th>
                            <th scope='col'>Plato</th>
                            <th scope='col'>Precio</th>
                            <th scope='col'>Cantidad</th>
                            <th scope='col'>Subtotal</th>
                            <th scope='col'>Especificación</th>
                            <th scope='col'>Guarnicion</th>
                            <th scope='col'>Extras</th>
                            <th scope='col'>Eliminar</th>
                        </tr>
                    </thead>";

                    $totalExtra=0;
                    $totalGuanicion=0;

                    if(isset($_GET['delete'])){
                        $id = $_GET['delete'];
                        $conn->query("UPDATE comandas SET status = 'Comanda_Cancelada' WHERE id_comanda = '$id'");
                        header('Location:comanda.php');
                    };
                    
                    $sql = "SELECT DISTINCT*,(costo*cantidad) AS total FROM comandas WHERE usuario = '$USR' AND status = 'Comanda' AND DATE(registro) = CURDATE()";
                    $result = $conn-> query($sql) or die ("error en query $sql".mysqli_error());
                    
                    /*$sql = "SELECT DISTINCT *, (costo*cantidad) as total, 
                            (Select ingrediente from guarnicones where id_guarnicion in (guarniciones)) AS guarnicion, 
                            (Select extras from inventarios where id_inventario in (extras)) as extras 
                            From comandas where usuario = '$USR' AND status='Comanda' AND DATE(registro) = CURDATE()";
                    $result = $conn-> query($sql) or die ("error en query $sql".mysqli_error());*/

                    if($result-> num_rows > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            if($row["extras"]!=null)
                            {
                                $sqlExtras="SELECT sum(precio) total from inventarios where producto in ('".$row["extras"]."')";
                                $resultExtra = $conn-> query($sqlExtras) or die ("error en query $sqlExtras".mysqli_error());
                                if($resultExtra->num_rows>0){
                                    /*$select_extras = "SELECT extras FROM inventarios Where id_inventario in (".$row["extras"].")";
                                    $e_select = $conn-> query($select_extras);
                                    $row_e ="";
                                    while($e = mysqli_fetch_assoc($e_select)){
                                        $row_e = $row_e." ".$e['extras'];
                                    }*/
                                    while($rowExtra = mysqli_fetch_assoc($resultExtra)) {
                                        $totalExtra =$rowExtra["total"];
                                    }
                                }
                            }
                            else
                            {
                                $totalExtra=0;
                            }
                            if($row["guarniciones"]!=null)
                            {
                                $sqlGuarniciones="SELECT sum(valor) total from guarnicones where ingrediente in ('".$row["guarniciones"]."')";
                                $resultGuarniciones = $conn-> query($sqlGuarniciones) or die ("error en query $sqlGuarniciones".mysqli_error());
                                if($resultGuarniciones->num_rows>0){
                                    /*$select_guarniciones = "SELECT ingrediente FROM guarnicones Where id_guarnicion in (".$row["guarniciones"].")";
                                    $r_select = $conn-> query( $select_guarniciones);
                                    $row_g = "";
                                    while($g = mysqli_fetch_assoc($r_select)){
                                        $row_g = $row_g." ".$g['ingrediente'];
                                    }*/
                                    while($rowGuarnicion = mysqli_fetch_assoc($resultGuarniciones)) {
                                        $totalGuanicion =$rowGuarnicion["total"];
                                    }
                                }
                            }
                            else{
                                $totalGuanicion = 0;
                            }
                            $precioTotal=$row["costo"] + $totalExtra + $totalGuanicion;
                            $subtotal=$precioTotal*$row["cantidad"];

                            echo "
                            <tbody>
                            <th scope='row'>".$row["usuario"]."</th>
                            <td>".$row["platillo"]."</td>
                            <td>$".$precioTotal."</td>
                            <td>".$row["cantidad"]."</td>
                            <td>$".$subtotal."</td>
                            <td>".$row["specs"]."</td>
                            <td>".$row["guarniciones"]."</td>
                            <td>".$row["extras"]."</td>
                            <td id='hidden'>".$row["status"]."</td>
                            <td><a href='comanda.php?delete=".$row["id_comanda"]."'><i class='fas fa-trash-alt'></i></a></td>";
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

                //foreach($result as $value){
                    $total = $subtotal;
                //};
    
    ?>
    </section>

    <section class="container">
    <!--<span id="total" class="btn btn-light h4">Total: $<?php //echo $total ?></span>-->
   <form action="" method="POST">
        <button type="submit" name="ordenar" class='btn btn-info btn-lg btn-block'>Ordenar</button>
   </form>
       
    <br>
    </section>
    <?php
        mysqli_close($conn);
    ?>
    <br>
    <?php //require_once('footer.html')?>
</body>
</html>