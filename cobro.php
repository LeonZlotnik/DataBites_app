<?php
session_start();
$USR = $_SESSION['usuario'];

if($USR == null){
    header("location:index.php");
}
    
    if(isset($_GET['Total'])){
        (int)$id = $_GET['Total'];
        $Total = (int)$id;
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <title>Menu principal</title>
    <style>
        .slider-h{
            height: 25vh;
        }

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

        
    </style>
</head>
<body>
    <?php include_once('nav_bar.php') ?>
    <br>

    <div class="comanda">
        <a href="cuenta.php"><i class="fas fa-dollar-sign"></i></a>
    </div>

        <h2 class="title">Tipo de Pago</h2>
    <br>

    <div class="container">
        <div class="card text-center">
            <h5 class="card-header">Efectivo</h5>
            <div class="card-body">
                <div class="card-body">
                    <img src="img/Cash_logo.png" width="50%" alt="">
                </div>
                <a href="efectivo.php?Total=<?php echo $Total ?>" class="btn btn-success btn-lg btn-block">Pagar</a>
            </div>
            <div class="card-footer text-muted">
                El mesero le asisitirá.
            </div>
            <br>
            <div class="card text-center">
            <h5 class="card-header">Terminal</h5>
            <div class="card-body">
                <div class="card-body">
                    <img src="img/terminal.png" width="50%" alt="">
                </div>
                <a href="terminal.php?Total=<?php echo $Total ?>" class="btn btn-success btn-lg btn-block">Pagar</a>
            </div>
            <div class="card-footer text-muted">
                El mesero le asisitirá.
            </div>
            <br>
            <div class="card text-center">
            <h5 class="card-header">Tarjeta</h5>
            <div class="card-body">
                <div class="card-body">
                    <img src="img/CreditCard.png" width="50%" alt="">
                </div>
                <a href="Paypage/pagos.php?Total=<?php echo $Total ?>" class="btn btn-success btn-lg btn-block">Pagar</a>
            </div>
            <div class="card-footer text-muted">
                Ingrese su número aquí.
            </div>
            
        </div>
<br>
    </div>
    <br>
    <?php require_once('footer.html')?>
</body>
</html>