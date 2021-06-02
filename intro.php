<?php
session_start();
$USR = $_SESSION['usuario'];
$MSA = $_SESSION['m'];

if($USR == null){
    header("location:index.php");
}
if($MSA == null){
    header("location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" type="img/png" href="img/favicon.png">
    <title>Menu principal</title>
    <style>
        .responsivo{
            display: block;
        }

        .mobile-screen{
            display: none;
        }

        @media screen and (max-width: 750px){
            .slider-h{
            height: 25vh;
        }

        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

        .contain{
            width:80%;
            min-height: 1300px;
            background-color: #000;
            margin: 30px auto 0;
            display: felx;

        }

        .contain .box{
            position: relative; top:15px;
            width: 80%;
            height: 100px;
            background-color: yellow;
            margin: 0 10% 0 10%;
            box-sizing: border-box;
            display: inline-block;
        }

        .contain .box .imgBox{
            position: relative;
            overflow: hidden;
        }

        .contain .box .imgBox img{
            width: 100%;
            transition: transform 2s;
        }

        .contain .box:hover .imgBox img{
            transform: scale(1.2);
        }

        .contain .box .details{
            position: absolute; top: 10px; left:10px; bottom: 10px; right:10px;
            background-color: rgba(0,0,0,.8);
            height: 28vh;
        }

        .contain .box .details .content{
            position: absolute; top: 50%;
            transform: translateY(-50%);
            text-align: center;
            color: #fff;
        }

        .contain .box .details .content h2{
            margin: 0;
            padding: 0;
            color: #4ae7ff;
            font-size: 35px;
        }

        .contain .box .details .content p{
            margin: 0;
            padding: 0;
            color: #fff;
            font-size: 20px;
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

        .mobile-screen{
            display: block;
        }

        .responsivo{
            display: none;
        }
        }

        @media screen and (max-width: 530px){
        .slider-h{
            height: 25vh;
        }

        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

        .contain{
            width:80%;
            min-height: 1050px;
            background-color: #000;
            margin: 30px auto 0;
            display: felx;

        }

        .contain .box{
            position: relative; top:15px;
            width: 80%;
            height: 100px;
            background-color: yellow;
            margin: 0 10% 0 10%;
            box-sizing: border-box;
            display: inline-block;
        }

        .contain .box .imgBox{
            position: relative;
            overflow: hidden;
        }

        .contain .box .imgBox img{
            max-width: 100%;
            transition: transform 2s;
        }

        .contain .box:hover .imgBox img{
            transform: scale(1.2);
        }

        .contain .box .details{
            position: absolute; top: 10px; left:10px; bottom: 10px; right:10px;
            background-color: rgba(0,0,0,.8);
            height: 20vh;
        }

        .contain .box .details .content{
            position: absolute; top: 50%;
            transform: translateY(-50%);
            text-align: center;
            color: #fff;
        }

        .contain .box .details .content h2{
            margin: 0;
            padding: 0;
            color: #4ae7ff;
            font-size: 28px;
        }

        .contain .box .details .content p{
            margin: 0;
            padding: 0;
            color: #fff;
            font-size: 16px;
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

        .mobile-screen{
            display: block;
        }

        .responsivo{
            display: none;
        }
        }

    @media screen and (max-width: 400px){
        .slider-h{
            height: 25vh;
        }

        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

        .contain{
            width:80%;
            min-height: 960px;
            background-color: #000;
            margin: 30px auto 0;
            display: felx;

        }

        .contain .box{
            position: relative; top:15px;
            width: 80%;
            height: 100px;
            background-color: yellow;
            margin: 9% 10% 9% 10%;
            box-sizing: border-box;
            display: inline-block;
        }

        .contain .box .imgBox{
            position: relative;
            overflow: hidden;
        }

        .contain .box .imgBox img{
            max-width: 100%;
            transition: transform 2s;
        }

        .contain .box:hover .imgBox img{
            transform: scale(1.2);
        }

        .contain .box .details{
            position: absolute; top: 10px; left:10px; bottom: 10px; right:10px;
            background-color: rgba(0,0,0,.8);
            height: 20vh;
        }

        .contain .box .details .content{
            position: absolute; top: 50%;
            transform: translateY(-50%);
            text-align: center;
            color: #fff;
        }

        .contain .box .details .content h2{
            margin: 0;
            padding: 0;
            color: #4ae7ff;
            font-size: 28px;
        }

        .contain .box .details .content p{
            margin: 0;
            padding: 0;
            color: #fff;
            font-size: 16px;
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

        .mobile-screen{
            display: block;
        }

        .responsivo{
            display: none;
        }
        }
        
        @media screen and (max-width: 300px){
        .slider-h{
            height: 25vh;
        }

        .title {
            text-align: center;
            color:#D7627C; 
            text-shadow: 1.5px 1px 2px #000;
        }

        .contain{
            width:80%;
            min-height: 760px;
            background-color: #000;
            margin: 30px auto 0;
            display: felx;

        }

        .contain .box{
            position: relative; top:15px;
            width: 80%;
            height: 100px;
            background-color: yellow;
            margin: 0 10% 0 10%;
            box-sizing: border-box;
            display: inline-block;
        }

        .contain .box .imgBox{
            position: relative;
            overflow: hidden;
        }

        .contain .box .imgBox img{
            max-width: 100%;
            transition: transform 2s;
        }

        .contain .box:hover .imgBox img{
            transform: scale(1.2);
        }

        .contain .box .details{
            position: absolute; top: 10px; left:10px; bottom: 10px; right:10px;
            background-color: rgba(0,0,0,.8);
            height: 20vh;
        }

        .contain .box .details .content{
            position: absolute; top: 50%;
            transform: translateY(-50%);
            text-align: center;
            color: #fff;
        }

        .contain .box .details .content h2{
            margin: 0;
            padding: 0;
            color: #4ae7ff;
            font-size: 20px;
        }

        .contain .box .details .content p{
            margin: 0;
            padding: 0;
            color: #fff;
            font-size: 12px;
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

        .mobile-screen{
            display: block;
        }

        .responsivo{
            display: none;
        }
        }
       

        
    </style>
</head>
<body>
    <?php include_once('nav_bar.php') ?>
    <br>

    <div class="comanda mobile-screen">
        <a href="comanda.php"><i class="fas fa-utensils"></i></a>
    </div>


        <h2 class="title mobile-screen">Menu Principal</h2>
        <div class="alert alert-danger container responsivo" role="alert">
            Dise帽o responsivo s贸lo para movil. 
        </div>
    <br>

    <?php
            require_once('z_connect.php');
        ?>

    <div class="container-fluid mobile-screen" id="slider-cut">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">

        <?php 
        $sql = "SELECT * FROM anuncios WHERE status = 'Activo' AND numero = 'First slide'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)){
        ?>
                    <a href="<?php echo $row['link'] ?>"><img class="d-block w-100 slider-h" <?php echo "src='admin/anuncios/".$row['imagen']."'";?> alt="Z"></a>
        <?php };?>
                    </div>
                <div class="carousel-item">
        <?php 
        $sql = "SELECT * FROM anuncios WHERE status = 'Activo' AND numero = 'Second slide'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)){
        ?>
                    <a href="<?php echo $row['link'] ?>"><img class="d-block w-100 slider-h" <?php echo "src='admin/anuncios/".$row['imagen']."'";?> alt="Z"></a>
        <?php };?>
                </div>
                <div class="carousel-item">
        <?php 
        $sql = "SELECT * FROM anuncios WHERE status = 'Activo' AND numero = 'Third slide'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)){
        ?>
                    <a href="<?php echo $row['link'] ?>"><img class="d-block w-100 slider-h" <?php echo "src='admin/anuncios/".$row['imagen']."'";?> alt="Z"></a>
        <?php };?>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="contain mobile-screen">
        <div class="box">
            <div class="imgBox">
                <img src="img/restaurante.jpeg" alt="">
            </div>
            <a href="bebidas.php">
            <div class="details">
                <div class="content">
                    <h2>Bebidas</h2>
                    <p>Refrescate con nuestras gran variedad de bebidas, sodas, cervezas y más.</p>
                </div>
            </div>
            </a>
        </div>
        <br>
        <br>
        <div class="box">
            <div class="imgBox">
                <img src="img/restaurante.jpeg" alt="">
            </div>
            <a href="entradas.php">
            <div class="details">
                <div class="content">
                    <h2>Entradas</h2>
                    <p>Deleitate con la variedad de sabores que tenemos para ti, para comparir o para una persona.</p>
                </div>
            </div>
            </a>
        </div>
        <br>
        <br>
        <div class="box">
            <div class="imgBox">
                <img src="img/restaurante.jpeg" alt="">
            </div>
            <a href="platillos.php">
            <div class="details">
                <div class="content">
                    <h2>Platillos</h2>
                    <p>Te sorpenderan nuestros deliciosos platillos, descubre nuestros platos fuertes.</p>
                </div>
            </div>
            </a>
        </div>
        <br>
        <br>
        <div class="box">
            <div class="imgBox">
                <img src="img/restaurante.jpeg" alt="">
            </div>
            <a href="especialidades.php">
            <div class="details">
                <div class="content">
                    <h2>Especialidades</h2>
                    <p>Descubre nuestras especialidades y dejanos concentir tu paladar.</p>
                </div>
            </div>
            </a>
        </div>
        <br>
        <br>
        <div class="box">
            <div class="imgBox">
                <img src="img/restaurante.jpeg" alt="">
            </div>
            <a href="postres.php">
            <div class="details">
                <div class="content">
                    <h2>Postres</h2>
                    <p>Para terminar no olvides un buen postre, para endulzar tu día.</p>
                </div>
            </div>
            </a>
        </div>
    </div>
    <br>
    <?php require_once('footer.html')?>
</body>
</html>