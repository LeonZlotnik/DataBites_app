<?php

$table = $_GET['m'];

if(isset($_POST['crear'])){
    $usuario = $_POST['usuario'];
    $table= $_GET['m'];

    require_once('z_connect.php');

    $sql = "INSERT INTO usuarios (usuario, mesa, codigo) VALUES ('$usuario',$table, LPAD(FLOOR(10+ RAND() * 10000),6,'0'))";
    $result = mysqli_query($conn, $sql);// or die ("error en query $sql".mysqli_error());

    if($result){
        session_start();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['m'] = $table;
        header('Location:intro.php');
      }else{
        $error = "<div class='alert alert-danger' role='alert'>El nombre de usuario ya existe, pruebe con otro. Siga las sugerencias para que le sea más sencillo.</div>";
      };
      
      mysqli_free_result($result);
      mysqli_close($conn); 

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Introducción</title>

<style>
    .hidden{
        display: none;
        visibility: hidden;
    }
    #login{
        position: absolute; bottom: 30px;
    }
    .title {
        text-align: center;
        color:#D7627C; 
        text-shadow: 1.5px 1px 2px #000;
    }
</style>
</head>
<body>
<?php include_once('session.php') ?>
<?php include_once('navbar_slim.php') ?>
<div class="container">
<br>
<h2 class="text-center title">Bienvenido</h2>
<br>
<div class="card mb-3">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="img/instucion_1.png" width="30%" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="img/instucion_2.png" width="30%" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="img/instucion_3.png" width="30%" alt="Third slide">
            </div>
        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title">Medidas para su seguridad.</h5>
        <p class="card-text">A manera de cuidar mejor su salud y respetar la sana distancia, le pedimos de la manera más atenta que de click en "Iniciar", para así hacer uso de este nuevo metodo de ordenar y pagar. </p>
        <p class="card-text"><small class="text-muted">Consulte a su mesero para más información</small></p>
    </div>
</div>

    <!-- Button trigger modal -->
<div class="container">
<button type="button" class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">
Iniciar
</button>
<a href="clientes.php?m=<?php echo $table?>" class="btn btn-success btn-lg btn-block">
            Cliente Frecuente
</a>  
</div>
<br>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <!-- Comienza form -->
        <form action="" name="myForm" method="POST">
        <h5 class="modal-title" id="exampleModalLabel">Inicio de sesión</h5>

        
    </div>
    <div class="modal-body">
        <p>Use el apartado para crear un usuraio, este se utilizará únicamente para identificar su orden. No será necesario que brinde información personal en ningun momento.</p>
        <p><i>Le recomendamos usar su RFC sin homoclave, en caso de que el nombre que ingrese ya exista.</i></p>
        <?php echo $error ?>
        <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="emailHelp" placeholder="Introduzca un nombre de usuario" required>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
        <input type="submit" id="submit" name="crear" value="Crear" class="btn btn-info"></input>
        <br>
       
    </div>
    </div>
    </form>
</div>
</div>
</div>

<?php require_once('footer.html')?>
</body>

</html>
<script>
/*document.getElementById("submit").addEventListener("click", function(event){
    user = document.getElementById("usuario")
    if(user == null){
        event.preventDefault()
        console.log('Error')
    }else{
        console.log('OK')
    }
    
});*/
</script>