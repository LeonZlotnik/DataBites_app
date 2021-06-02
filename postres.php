<?php
session_start();
$USR = $_SESSION['usuario'];

if($USR == null){
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas</title>
    <style>
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

        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }
        .cantidad{
            display: flex;
        }

        .position{
            position: relative; left: 10%;
        }
    </style>
</head>
<body>
<?php include_once('nav_bar.php') ?>

    
<div class="comanda">
        <a href="comanda.php"><i class="fas fa-utensils"></i></a>
    </div>

    <section class="container">
        <br>
        <h2 class="title">Postres</h2>
        <br>
    <form class="container">
        <div class="form-group mx-sm-3 mb-2">
            <input type="text" class="form-control" id="search" placeholder="Buscar...">
        </div>
    </form>
    <br>
       
        <?php
            require_once('z_connect.php');

            $sql = "SELECT * FROM platillos WHERE categoria = 'postres' AND estado = 'existente' ORDER BY 'platillo' DESC";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)){
        ?>

            <div class="card-deck">
                <div class="card mb-3 producto">
                    <img class="card-img-top" <?php echo "src='admin/img_menu/".$row['imagen']."'";?> alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['platillo']?></h5>
                        <div class="btn btn-light">
                            Likes <span class="badge badge-light"><?php echo $row['likes']?></span>
                        </div>
                        <br>
                        <br>
                        <p class="card-text"><?php echo $row['descripcion']?></p>
                        <div class="input-group-text" id="btnGroupAddon">$ <?php echo $row['precio']?> MXN</div>
                        <br>
                        <div class="cantidad">
                            <?php echo "<a href='detalles.php?ID={$row['id_platillo']}&plato={$row['platillo']}' class='btn btn-outline-info'>Detalles</a>" ?>
                        </div>
                    </div>
                    </div>
                    </div>
                <?php
            }
                ?>
    </section>
    <br>
    <?php require_once('footer.html')?>
</body>
<script type='text/javascript'>
             let search_input = document.getElementById('search')
            
            search_input.addEventListener('keyup',function(e){
                let search_item = e.target.value.toLowerCase();
                let div_item = document.querySelectorAll("div .producto");
                console.log(search_item);
                
                div_item.forEach(function(item){
                    if(item.textContent.toLowerCase().indexOf(search_item)!=-1){
                      item.closest("div").style.display = "block";
                    }else{
                      item.closest("div").style.display = "none";
                    }
                });
            });
    </script>
</html>