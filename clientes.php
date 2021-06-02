<?php  

require_once('z_connect.php');

  $table = $_GET['m'];

  if(isset($_POST['login'])){
      $client = $_POST["cliente"];
      $password = $_POST["pw"];
      $table = $_GET['m'];

      $query = "SELECT * FROM clientes WHERE cliente='$client' AND pw='$password'";
      $result = mysqli_query($conn, $query);

      $edit = "UPDATE clientes SET mesa = $table, codigo = LPAD(FLOOR(10+ RAND() * 10000),6,'0') WHERE cliente = '$client'";
      $res = mysqli_query($conn, $edit);// or die ("error en query $edit".mysqli_error());

      if($res){
        echo "Success";
        $_SESSION['m'] = $table;
    }else{
        $error = "<div class='alert alert-danger' role='alert'>Hubo un error de conexi®Æn, porfavor vuelva a escanear el c®Ædigo QR</div>";
    };

      if(mysqli_num_rows($result)>0){
          while($row = mysqli_fetch_assoc($result)){
              if($row["cliente"]){
                  session_start();
                  $_SESSION['usuario'] = $row["cliente"];
                  $_SESSION['m'] = $table;
                  header('Location:intro.php?Bienvenido='.$_SESSION['usuario']);
              }
          }
      }else{
          $msg = "<div class='alert alert-danger' role='alert'>Acceso negado, verifique la informacion</div>";
      }

  }
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administradores</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
      .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

        @media screen and (max-width: 750px){
        #login{
            margin-top: 35%;
        }
            }
        @media screen and (max-width: 450px){
        #login{
            margin-top: 50%;
        }
            }
            @media screen and (max-width: 380px){
        #login{
            margin-top: 72%;
        }
            }
            @media screen and (max-width: 370px){
        #login{
            margin-top: 35%;
        }
            }
    </style>
</head>
<body>
<?php include_once('navbar_slim.php') ?>
<br>
<h2 class="text-center title">Cliente Frecuente</h2>
<br>
<section class="container">
<?php echo $msg ?>
<?php echo $error ?>
<form action="" method="POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Mail</label>
    <input type="email" name="cliente" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="cliente@mail.com">
    <small id="emailHelp" class="form-text text-muted">Si se ha registrado previamente para formar parte de nuestros clientes frecuentes, ingrese el correo con el que se di√≥ de alta.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="pw" class="form-control" id="exampleInputPassword1" placeholder="Contrase√±a">
  </div>
  <input type="submit" class="btn btn-primary" name="login" value="Entrar">
</form>
<div class="container" id="login">
<a href="index.php?m=<?php echo $table?>" class="btn btn-info btn-lg btn-block">
    Atras
</a> 
</div>
 
</section>
<br>
<?php require_once('footer.html')?>
</body>
</html>