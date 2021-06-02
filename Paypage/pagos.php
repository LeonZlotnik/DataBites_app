<?php
session_start();
$USR = $_SESSION['usuario'];
//$MSA = $_SESSINO['m'];

if($USR == null){
    header("location:preferencias.php");
}
require_once('../z_connect.php');
$conn->set_charset("utf8");
/*if(isset($_POST['propina'])){
  $tip = $_POST['inlineRadioOptions'];

  $sql = "INSERT INTO comandas (propina) VALUES ('$tip')";
}*/

if(isset($_GET['Total'])){
    (int)$id = $_GET['Total'];
    $Total = (int)$id;
  }

?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" href="../style.css">
    <style>
      .StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
.title {
        text-align: center;
        color:#D7627C; 
        text-shadow: 1.5px 1px 2px #000;
    }
    </style>
</head>
<body>
<?php
require_once("nav_bar_pay.php");
?>
<br>
<section class="container">
<h4 class="my-4 text-center title">Pago Con Tarjeta</h4>
<form action="./charge.php" method="post" id="payment-form">
  <div class="form-row">
      <input type="hidden" name="nom_usuario" value="<?php echo $USR ?>" class="form-control mb-3 StripeElement StripeElement--empty">
      <input type="hidden" name="total" value="<?php echo $Total ?>" class="form-control mb-3 StripeElement StripeElement--empty">
      <input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Email Address" required>
      
        <div id="card-element" class="form-control">
        <!-- A Stripe Element will be inserted here. -->
        </div>

    <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
  </div>
  <!--<br>
  <h5 class="h5">Propina: </h5>
  <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value=1.1>
          <label class="form-check-label" for="inlineRadio1">10%</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value=1.15>
          <label class="form-check-label" for="inlineRadio2">15%</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value=1.2>
          <label class="form-check-label" for="inlineRadio3">20%</label>
          <input type="submit"class="btn btn-success" name="propina" value="Añadir Propina"/>
    </div>-->
  <button>Generar Pago</button>
</form>
</section>
<br>
<br>
<section class="container">
<div class="card row">
  <div class="card-body col-12">
    <p class="card-text">
    Introduzca el mail para recibír el comprobante de su cunta, esta información no será utilizada para fines comerciales. 
    </p>
    <p class="card-text">
    Si el número de tarjeta no se introduce bien o marca error, favor de verificar la información. Los errores de pago se pueden generar si no se introduce adecuadamente la información. 
    </p>
  </div>
</div>
</section>
<br>
<section class="container">
    <a class="btn btn-info btn-lg btn-block" href="../cuenta.php?total=<?php echo $Total ?>">Atras</a>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="charge.js"></script>
</body>
<br>
<br>
<br>
<br>
<?php require_once('../footer.html')?>
</html>
