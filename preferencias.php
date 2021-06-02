<?php
    session_start();
    $USR = $_SESSION['usuario'];
    $MSA = $_SESSION['m'];
    if($USR == null){
        header("location:index.php");
    }
   
    if(isset($_POST['crear'])){
        require_once('z_connect.php');

        $mail = $_POST['cliente'];
        $pw = $_POST['pw'];
        $birth = $_POST['cumple'];

        $sql = "INSERT INTO clientes (cliente, pw, cumple, codigo) VALUES ('$mail', '$pw', '$birth', LPAD(FLOOR(10+ RAND() * 10000),6,'0'))";
        $result = mysqli_query($conn, $sql) or die ("error en query $sql".mysqli_error());

        if($result){
            $success = "<br><div class='alert alert-success' role='alert'>
            ¡Felicidades! Ahora es parte de nuestros clientes consentidos.
            </div><br>";
          }else{
            echo "<script type='text/javascript'>alert('Se ha generado un error');</script>";
          };
          
          mysqli_free_result($result);
          mysqli_close($conn);
    };

    if(isset($_POST['comentar'])){
        require_once('z_connect.php');

        $comment = $_POST['comentario'];

        $query = "INSERT INTO comentarios (comentario) VALUES ('$comment')";
        $return = mysqli_query($conn, $query ) or die ("error en query $query ".mysqli_error());

        if($return){
            $ok = "<br><div class='alert alert-success' role='alert'>
            Gracias por compartinos su opinión. Nos seguiremos esforzando para mejorar el servicio.
            </div><br>";
          }else{
            echo "<script type='text/javascript'>alert('El comentario presentó un error');</script>";
          };
          
          mysqli_free_result($return);
          mysqli_close($conn);
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferencias</title>
    <style>
        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

        .comanda{
            position:fixed; bottom:40px; right:20px;
            transform: translateX(-50%);
            background: linear-gradient(to top, #4ae7ff, #CFEEF9 );
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

<div class="comanda">
        <a href="comanda.php"><i class="fas fa-utensils"></i></a>
    </div>

    <div class="container">
        <br>
        <h3 class="title">Preferencias</h3>
        <br>
        <div class="alert alert-primary" role="alert">
        <?php 
            echo "Usuario: ".$USR;
        ?>
        </div>
        <div class="alert alert-info" role="alert">
        <?php 
            echo "Mesa: ".$MSA;
        ?>
        </div>
        <div class="container">
                        <?php echo $success ?>
                        <?php echo $ok ?>
        </div>
        <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Cliente Frecuente
                                </button>
                            </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                Si desea formar parte de los clientes frecuentes llene este formulario. Al llenar el formulario esta aceptando recibir informacion del Newsletter.
                                <br>
                                <br>
                                <form action="" method="POST">
                                    <label for="exampleFormControlInput1">Mail</label>
                                    <input type="email" name="cliente" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                                    <br>
                                    <label for="exampleFormControlInput1">Cumpleaños</label>
                                    <input type="date" name="cumple" class="form-control" id="exampleFormControlInput1" placeholder="fecha de nacimiento">
                                    <br>
                                
                                    <label for="exampleFormControlInput1">Contraseña</label>
                                    <input type="password" name="pw" class="form-control" id="exampleFormControlInput1" placeholder="contraseña" required>
                                    <br>
                                    <button type="submit" name="crear" class="btn btn-primary btn-lg btn-block">Agregar</button>
                                </form>
       
                            </div>
                           
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Facturar
                                </button>
                            </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                       <p class="h3">Proximamente</p>
                                        <!--<button type="button" class="btn btn-primary btn-lg btn-block">Cambiar</button>-->
                                <br>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Comentarios
                                </button>
                            </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                Por favor deje sus comentarios si cree que hay algo en lo que podríamos mejorar. 
                                <br>
                                <br>
                            <form action="" method="POST">
                                <div class="input-group">
                                    <textarea name="comentario" class="form-control" aria-label="With textarea" required></textarea>
                                </div>
                                <br>
                                <button type="submit" name="comentar" class="btn btn-primary btn-lg btn-block">Enviar</button>
                            </form>
                            </div>
                            
                        </div>
                        </div>
                        </div>
                    
    </div>
    <br>
    <?php require_once('footer.html')?>
</body>
</html>