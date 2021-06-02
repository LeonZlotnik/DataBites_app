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
    <title>Control de Clientes</title>
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
        <h3 class="title">Contro de Clientes</h3>
    <br>
    <form class="container">
        <div class="form-group mx-sm-3 mb-2">
            <input type="text" class="form-control" id="search" placeholder="Buscar...">
        </div>
    </form>
    <br>
    <div class="col text-center">
        <a class="btn btn-dark btn-lg" href="panel.php">Atras</a>
        <a href="xport_clientes.php" class="btn btn-default btn btn-success btn-lg">Exportar</a>
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
                            <th scope='col'>Mail</th>
                            <th scope='col'>Contraseña</th>
                            <th scope='col'>Cumpleaños</th>
                            <th scope='col'>Token</th>
                            <th scope='col'>Registro</th>
                            <th scope='col'>Eliminar</th>
                        </tr>
                    </thead>";

                    $sql = "SELECT * FROM clientes";
                    $result = $conn-> query($sql) or die ("error en query $sql".mysqli_error());

                    if($result-> num_rows > 0) {
                    
                        while($row = mysqli_fetch_assoc($result)){
                            echo "
                            <tbody>
                            <th scope='row'>".$row["id_cliente"]."</th>
                            <td class='mail'>".$row["cliente"]."</td>
                            <td>XXXXXX</td>
                            <td>".$row["cumple"]."</td>
                            <td>".$row["codigo"]."</td>
                            <td>".$row["registro"]."</td>
                            <td><a href='control_clientes.php?delete=".$row["id_cliente"]."'><i class='fas fa-trash-alt'></i></a></td>";
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

                if(isset($_GET['delete'])){
                    $id = $_GET['delete'];
                    $conn->query("DELETE FROM clientes WHERE id_cliente = '$id'");
                }
    
    ?>
    </section>
    </section>
    <script type='text/javascript'>
            let search_input = document.getElementById('search')
            
            search_input.addEventListener('keyup',function(e){
                let search_item = e.target.value.toLowerCase();
                let td_item = document.querySelectorAll("table tbody .mail");
                console.log(td_item);
                
                td_item.forEach(function(item){
                    if(item.textContent.toLowerCase().indexOf(search_item)!=-1){
                        item.closest("table tr").style.display = "block";
                    }else{
                        item.closest("table tr").style.display = "none";
                    }
                });
            });
    </script>
    <?php  $connect-> close();?>
</body>
</html>

