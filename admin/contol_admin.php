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
    <title>Control de Administradores</title>
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
        <h3 class="title">Contro de Administradores</h3>
        <br>
    <div class="col text-center">
        <a class="btn btn-dark btn-lg" href="panel.php">Atras</a>
      <a href="crearadmin.php" class="btn btn-default btn btn-dark btn-lg">Crear Administrador</a>
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
                            <th scope='col'>#</th>
                            <th scope='col'>Usuario</th>
                            <th scope='col'>Contraseña</th>
                            <th scope='col'>Acceso</th>
                            <th scope='col'>Registro</th>
                            <th scope='col'>Eliminar</th>
                        </tr>
                    </thead>";

                    if(isset($_GET['delete'])){
                        $id = $_GET['delete'];
                        $conn->query("DELETE FROM administradores WHERE id_admin = '$id'");
                    }

                    $sql = "SELECT * FROM administradores";
                    $result = $conn-> query($sql) or die ("error en query $sql".mysqli_error());

                    if($result-> num_rows > 0) {
                    
                        while($row = mysqli_fetch_assoc($result)){
                            echo "
                            <tbody>
                            <th scope='row'>".$row["id_admin"]."</th>
                            <td>".$row["usuario"]."</td>
                            <td>".$row["password"]."</td>
                            <td>".$row["acceso"]."</td>
                            <td>".$row["registro"]."</td>
                            <td><a href='contol_admin.php?delete=".$row["id_admin"]."'><i class='fas fa-trash-alt'></i></a></td>";
                }
                    echo "
                        </tbody>
                    </table>
                </div>";
                }
                else {
                    echo "<div class='alert alert-warning' role='alert'>
                    No hay informaci贸n por el momento.
                          </div>";
                }

                $connect-> close();
    
    ?>
    </section>
</body>
</html>

