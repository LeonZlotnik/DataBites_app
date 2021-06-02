<?php
    session_start();
    $USR = $_SESSION['usuario'];
    //$MSA = $_SESSINO['m'];

    if($USR == null){
        header("location:index.php");
    }

if (isset($_POST['invitar'])) {
    require_once('z_connect.php');
    $users = implode(", ", $_POST['usuarios']);

    $sqlMesa= "update comandas c set c.invita='$USR', c.estatus_invitacion='PENDIENTE' where c.status='Cuenta' and DATE(c.registro) = CURDATE() and c.mesa = (SELECT * FROM(SELECT distinct(cm.mesa) FROM comandas cm  where cm.usuario='$USR' and cm.status = 'Cuenta')mesa) and c.usuario in ('$users')";
    $res = mysqli_query($conn, $sqlMesa) or die ("error en query $sqlMesa".mysqli_error());

    if($res){
        echo "";
    }else{
        echo"Error";
    };
    header("Refresh:0");
//    echo"<script type=" . "text/javascript" . ">
//    alert('" . $users . "');
//    </script>";
}

if (isset($_POST['aceptar_invitacion'])) {
    require_once('z_connect.php');

    $sqlupdateComandasFinales= "update comandas c set c.estatus_invitacion='ACEPTADA' where c.status='cuenta' and DATE(c.registro) = CURDATE() and c.mesa = (SELECT * FROM(SELECT distinct(cm.mesa) FROM comandas cm  where cm.usuario='$USR')mesa) and c.usuario in ('$USR')";
    $res = mysqli_query($conn, $sqlupdateComandasFinales) or die ("error en query $sqlupdateComandasFinales".mysqli_error());

    if($res){
        echo "";
    }else{
        echo"Error";
    };
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
            background: linear-gradient(to top, #4ae7ff, #CFEEF9);
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
        #position{
            position: absolute; bottom:1px;
        }
    </style>
</head>
<body>
<?php include_once('nav_bar.php') ?>
<form action="" method="POST">
<div class="comanda">
        <a href="comanda.php"><i class="fas fa-utensils"></i></a>
    </div>

    <section class="container">

    <br>
        <h3 class="title">Cuenta</h3>
    <br>

    <?php 
         require_once('z_connect.php');

        echo "
        <div class='table-responsive'>
        <table class='table table-hover'>
                    <thead>
                        <tr class='table-success'>
                            <th scope='col'>Usuario</th>
                            <th scope='col'>Plato</th>
                            <th scope='col'>Precio</th>
                            <th scope='col'>Cantidad</th>
                            <th scope='col'>Total</th>
                            <th scope='col'>Porción</th>
                            <th scope='col'>Guarnición</th>
                            <th scope='col'>Extras</th>
                            <th id='hidden' scope='col'>Tiempo</th>
                        </tr>
                    </thead>";

                    $totalExtra=0;
                    $subtotalFinal =0;
                    $totalGuanicion=0;

                    $sql = "SELECT *,(costo*cantidad) AS total 
                            from comandas
                            WHERE usuario = '$USR' AND status = 'Cuenta' AND DATE(registro) = CURDATE()
                            union   
                            SELECT id_comanda, usuario, platillo, costo, cantidad, specs, status, mesa, invita, registro, estatus_invitacion, extras, guarniciones, (costo*cantidad) AS total 
                            FROM comandas WHERE  status = 'Cuenta' AND DATE(registro) = CURDATE() and invita='$USR' and estatus_invitacion='ACEPTADA'";
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
                            else
                            {
                                $totalExtra=0;
                            }

                            if($row["guarniciones"]!=null)
                            {
                                $sqlGuarniciones="SELECT sum(valor) total from guarnicones where ingrediente in ('".$row["guarniciones"]."')";
                                $resultGuarniciones = $conn-> query($sqlGuarniciones) or die ("error en query $sqlGuarniciones".mysqli_error());
                                if($resultGuarniciones->num_rows>0){
                                    while($rowGuarnicion = mysqli_fetch_assoc($resultGuarniciones)) {
                                        $totalGuanicion =$rowGuarnicion["total"];
                                    }
                                }
                            }
                            else{
                                $totalGuanicion=0;
                            }
                            $precioTotal=$row["costo"] + $totalExtra + $totalGuanicion;
                            $subtotal = $precioTotal * $row["cantidad"];

                            $subtotalFinal += $subtotal;

                            echo "
                            <tbody>
                            <th scope='row'>".$row["usuario"]."</th>
                            <td>".$row["platillo"]."</td>
                            <td>$".$precioTotal."</td>
                            <td>".$row["cantidad"]."</td>
                            <td>$".$subtotal."</td>
                            <td>".$row["size"]."</td>
                            <td>".$row["guarniciones"]."</td>
                            <td>".$row["extras"]."</td>
                            <td id='hidden'>".$row["registro"]."</td>
                            <td id='hidden'>".$row["status"]."</td>";
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

                /*foreach($result as $value){
                    $subtotal += $value["total"];*/
                    $total = $subtotalFinal;
                /*};*/

    ?>
    </section>

    <section class="container">
    <span id="total" class="btn btn-light h4"><strong>Total: $<?php echo $total ?></strong></span>
    <a href="cobro.php?Total=<?php echo $total ?>" class='btn btn-success btn-lg btn-block'>Pagar</a>
    <br>
    </section>

<section class="container">
    <?php
    require_once('z_connect.php');

    echo "
    <br>
    <br>
    <div class='row'>
    <div class='col-6'>
    
        <h5>Agrega los Usuario que quieres invitar</h5>
        <div class='table-responsive'>
        <table class='table table-hover'>
                    <thead>
                        <tr class='table-success'>
                            <th scope='col'>Usuario</th>
                            
                        </tr>
                    </thead>";

    $sql = "SELECT DISTINCT (usuario) FROM comandas where mesa = (select distinct(mesa) from comandas where usuario = '$USR' AND DATE(registro) = CURDATE()) and usuario not in ('$USR') and DATE(registro) = CURDATE() AND status = 'Cuenta'" ;
    $result = $conn-> query($sql) or die ("<div class='alert alert-danger'>Duplicidad de usuario </div>");

    if($result-> num_rows > 0) {
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            echo "
                            <tbody>
                            <td>
                                <label id=". row["usuario"] ." for=". "users" . ++$i .">
                                    " . $row["usuario"] . "
                                </label>
                             <input type='checkbox' id=". "user" . $i ." name=" . "usuarios[]" ."
                                value=".$row["usuario"].">  
                            </td>
                             ";

        }
        echo "
                        </tbody>
                    </table>
                </div>
                </div>
                <div class='col-6'>";

        $sqlInvita = "SELECT DISTINCT (invita) FROM comandas where mesa = (select distinct(mesa) from comandas where usuario = '$USR' AND DATE(registro) = CURDATE()) and usuario in ('$USR') and estatus_invitacion = 'PENDIENTE'" ;
        $resInvita= $conn-> query($sqlInvita) or die ("error en query $sqlInvita".mysqli_error());

        $numInvitacion=0;
        $invita ='';
        if($resInvita-> num_rows > 0) {
            while($invitacion = mysqli_fetch_assoc($resInvita)){
                $numInvitacion+=1;
                $invita=$invitacion['invita'];
            }
        }
        if($numInvitacion>0){
            echo "<div class='alert alert-warning' role='alert'>
                        Tienes una invitación de parte de: $invita
                    </div>
                         <input class=\"btn btn-success\" type=\"submit\" name=\"aceptar_invitacion\" value=\"Aceptar\" >
                        ";
        }
        else{
            echo "<div class='alert alert-warning' role='alert'>
                    No hay información por el momento.
                          </div>";
        }
        echo"</div>
                ";
    }
    /*else {
        echo "<div class='alert alert-warning' role='alert'>
                    No hay información por el momento.
                          </div>";
    }*/
    "
        </div>
    </div>
    </form>
    "
    ?>
</section>

<section class="container">
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4">
            <input class="btn btn-success" type="submit" name="invitar" value="Invitar" >
        </div>
        <div class="col-4">
        </div>
    </div>
    <br>
</section>


    <?php
        mysqli_close($conn);
    ?>
    <br>
    
        <?php //require_once('footer.html')?>

    
</body>
</html>
