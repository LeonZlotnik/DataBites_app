<?php
session_start();
$USR = $_SESSION['usuario'];
//$MSA = $_SESSINO['m'];

if($USR == null){
    header("location:preferencias.php");
}
require_once('z_connect.php');

if(isset($_GET['Total'])){
    (int)$id = $_GET['Total'];
    $Total = (int)$id;
  }


if(isset($_POST['validar_token'])){
    $token = $_POST['token'];
    $email = $_POST['email'];

    $sql="select count(*) total from usuarios where usuario='$USR' and codigo='$token'";
    $res=mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($res);
    $countExist= $row["total"];
    if ($countExist>0) {
        $paid = "UPDATE comandas SET status= 'Pagado' WHERE usuario = '$USR' AND DATE(registro) = CURDATE() AND status = 'Cuenta' or invita = '$USR'";
        $res = mysqli_query($conn, $paid) or die ("error en query $paid".mysqli_error());
        header('Location:hecho.php?total='.$Total);
    } else {
        $error = "<div class='alert alert-danger' role='alert'>
                Código Inválido, favor de verificarlo U.
        </div>";
    }
    
    $query="select count(*) total from clientes where cliente='$USR' and codigo='$token'";
    $clear=mysqli_query($conn,$query);
    $line = mysqli_fetch_array($clear);
    $count= $line["total"];
    if ($count>0) {
        $pay = "UPDATE comandas SET status= 'Pagado' WHERE usuario = '$USR' AND DATE(registro) = CURDATE() AND status = 'Cuenta' or invita = '$USR'";
        $clear = mysqli_query($conn, $pay) or die ("error en query $pay".mysqli_error());
        header('Location:hecho.php?total='.$Total);
    } else {
        $error = "<div class='alert alert-danger' role='alert'>
                Código Inválido, favor de verificarlo C.
        </div>";
    }
}
s
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" href="../style.css">
    <style>
.title {
        text-align: center;
        color:#D7627C; 
        text-shadow: 1.5px 1px 2px #000;
    }
    </style>
</head>
<body>
<?php
require_once("nav_bar.php");
?>
<br>
<section class="container">
<h4 class="my-4 text-center title">Pago en Terminal</h4>
<div class="card row">
    <div class="card-body col-12">
        <p class="card-text h5"><b><?php echo $USR ?>, su total a pagar es de: $<?php echo $Total ?></b></p>
        <p class="card-text">Porfavor, deje la propina por aparte. Le agradecemos mucho su visita.</p>
        <div class="container">
            <?php echo $success ?>
            <?php echo $error ?>
        </div>
    </div>
</div>
<br>
<form method="post" id="payment-form">
  <div class="form-row">
      <input type="text" name="token" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Ingrese Token" required>
      <!--<input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Email Address" required>-->
  </div>
  
  <button class="btn btn-primary btn-lg btn-block" name="validar_token">Generar Pago</button>
</form>
</section>
<br>
<br>
<section class="container">
<div class="card row">
  <div class="card-body col-12">
    <p class="card-text">
    <b>Importante:</b> El mesero deberá de proporcionarle su Token. Es indispensable que lo introduzca en el apartado superiór para concluir el servicio. 
    </p>
    <p class="card-text">Si tiene cualquier duda, el mesero le asisitirá</p>
  </div>
</div>
</section>
<br>
<section class="container">
    <a class="btn btn-info btn-lg btn-block" href="cuenta.php?total=<?php echo $Total ?>">Atras</a>
</section>
</body>
<br>
<br>
<br>
<br>
<?php require_once('footer.html')?>
</html>
