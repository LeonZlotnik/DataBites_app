<?php
    
    session_start();
    //$USR = $_SESSION['usuario'];
    //$MSA = $_SESSINO['m'];
    
    //if($USR == null){
    //    header("location:preferencias.php");
    //}
    require_once('vendor/autoload.php');

    \Stripe\Stripe::setApiKey('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');

    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    $nom_usuario = $POST['nom_usuario'];
    $total = $POST['total'];
    $email = $POST['email'];
    $token = $POST['stripeToken'];

    //Crear Customer 
    $customer = \Stripe\Customer::create(array(
        "email" => $email,
        "source" => $token
    ));

   // Charge Customer
    $charge = \Stripe\Charge::create(array(
    "amount" => (int)$total*100,
    "currency" => "mxn",
    "description" => "Consumo de Insumos",
    "customer" => $customer->id
  ));

    //print_r($charge);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gracias!</title>
  <link rel="shorcut icon" type="img/png" href="img/favicon.png">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
require_once("nav_bar_pay.php");
?>
<br>
<section class="container">
<div class="card text-center">
  <div class="card-header">
    ¡Pago Exitoso!
  </div>
  <div class="card-body">
    <h5 class="card-title">Gracias por su visita <?php echo $nom_usuario ?></h5>
    <p class="card-text">El total de su cuenta fue de ($<?php echo $total ?> mxn)</p>
    
    <?php
    session_start();
    if(isset($_SESSION['usuario'])){
        echo "<a href='logout.php?salir' class='btn btn-info btn-lg btn-block'>Terminar</a>";
    }
    ?>
  </div>
  <div class="card-footer text-muted">
    Información enviada a <?php echo $email ?>
  </div>
</div>
</section>
</body>
<br>
<br>
<br>
<?php require_once('../footer.html')?>
</html>

<?php 

//SMTP

$to = $email;

$subject = 'Hijas de la Tostada - Comprobante de pago por $'.$total;

$message = 'Gracias por visitarnos '.$nom_usuario.'';
            'Cualquier duda favor de comunicarse por este medio. Estámos para ayudarle';

$headers = "Enviado Por:comprobantes@mail.com"."\r\n";
$headers .= "Responder: comprobantes@mail.com"."\r\n";
$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

mail($to, $subject, $message, $headers);

require_once('../z_connect.php');
         
  //$paid = "UPDATE comandas SET status= 'Pagado' WHERE usuario = '$USR' AND DATE(registro) = CURDATE() AND status = 'Cuenta'";
  $paid = "UPDATE comandas SET status= 'Pagado' WHERE usuario = '$USR' AND DATE(registro) = CURDATE() AND status = 'Cuenta' or invita = '$USR'";
  $res = mysqli_query($conn, $paid) or die ("error en query $paid".mysqli_error());

  /*$invita = "SELECT invita FROM comandas Where usuario = '$USR'";
  $arr = array_split($invita, ",");

foreach($arr as $value => $skey){
  $together = "UPDATE comandas SET status= 'Pagado' WHERE  usuario trim ($arr[$key]) AND DATE(registro) = CURDATE() AND status = 'Cuenta'";
  $res_t = mysqli_query($conn, $together) or die ("error en query $together ".mysqli_error());
};*/

?>
