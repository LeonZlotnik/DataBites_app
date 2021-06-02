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
    <title>Detalles</title>
    <style>
        .comanda {
            position: fixed;
            bottom: 40px;
            right: 20px;
            transform: translateX(-50%);
            background: linear-gradient(to top, #4ae7ff, #CFEEF9);
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

        .comanda a {
            color: white;
            position: relative;
            top: 1px;
        }

        .title {
            text-align: center;
            color:#D7627C;
            text-shadow: 1.5px 1px 2px #000;
        }
    </style>
</head>

<body>
<?php include_once('nav_bar.php') ?>

<div class="comanda">
    <a href="comanda.php"><i class="fas fa-utensils"></i></a>
</div>

<?php

require 'z_connect.php';


if (isset($_GET['ID'])) {

    $ID = mysqli_real_escape_string($conn, $_GET['ID']);
    $N = mysqli_real_escape_string($conn, $_GET['platillo']);

  $sql = "SELECT * FROM platillos WHERE id_platillo = $ID";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $likes=$row["likes"];

    $sqlCountLike="select count(*)total from like_platillo where user='$USR' and id_platillo=".$ID;
    $resCountLike=mysqli_query($conn,$sqlCountLike);
    $rowLike = mysqli_fetch_array($resCountLike);
    $totalLike= $rowLike["total"];
}

if (isset($_POST['add_to_cart'])) {


  $username = $_POST["usuario"];
  $product = $_POST["platillo"];
  $price = $_POST["costo"];
  $amount = $_POST["cantidad"];
  $specs = $_POST["specs"];
  $status = $_POST["status"];
  $table = $_POST["mesa"];
  $extras = implode(", ", $_POST['extras']);
  $guarniciones = implode(", ", $_POST['guarniciones']);

  $sql = "INSERT INTO comandas (usuario, platillo, costo, cantidad, specs, status, mesa, extras, guarniciones) VALUES ('$username','$product','$price','$amount','$specs','$status','$table', '$extras', '$guarniciones')";
  $res = mysqli_query($conn, $sql); //or die ("error en query $sql".mysqli_error());

  if ($res) {
    $success = "<div class='alert alert-success' role='alert'>
          El producto fue agregado exitosamente!
          </div>";
  } else {
    $error = "<div class='alert alert-danger' role='alert'>
    Verifique su nombre de ususario, revise en Preferencias.
    </div>";
  };

  mysqli_free_result($res);
  mysqli_close($conn);
}

if (isset($_POST['set_like'])) {
    $sqlCountLike="select count(*)total from like_platillo where user='$USR' and id_platillo=".$ID;
    $resCountLike=mysqli_query($conn,$sqlCountLike);
    $rowLike = mysqli_fetch_array($resCountLike);
    $totalLike= $rowLike["total"];

    if($totalLike==0) {
        if ($likes != null) {
            $likes += 1;
        } else {
            $likes = 1;
        }
        $sqlLike = "insert into like_platillo (user, id_platillo, likes, fecha_registro) values ('$USR',$ID, 1, CURDATE())";
        $resLike = mysqli_query($conn, $sqlLike);

        $sql = "update platillos set likes=$likes where id_platillo=$ID";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $success = "<div class='alert alert-success' role='alert'>
          Se califico correctamente el platillo
          </div>";
        } else {
            $error = "<div class='alert alert-danger' role='alert'>
   Verifique su información
    </div>";
        }
        header("Refresh:0");
    }
}
?>
<div class="container">
    <br>
    <h2 class="title">Detalles</h2>
    <br>
    <div class="card-deck">
        <div class="card mb-3">
            <img class="card-img-top" <?php echo "src='admin/img_menu/" . $row['imagen'] . "'"; ?> alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['platillo']; ?></h5>
                <form action="" method="POST">
                    <button type="submit" name="set_like" value="Like" class="btn btn-info"<?php
                    if($totalLike>0)
                        echo 'disabled'
                    ?>><i
                                class="fas fa-thumbs-up"></i></button>
                </form>

                <br>
                <div id="accordion">

                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" name="sum" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Detalles del plato
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                             data-parent="#accordion">
                            <div class="card-body">
                              <?php echo $row['detalle']; ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="input-group-text" id="btnGroupAddon">$ <?php echo $row['precio'] ?> MXN</div>

                <br>
                <div id="accordion">

                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Ordenar
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                             data-parent="#accordion">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <!--<div class="form-group">
                                        <div class="col-12">
                                            <p class="h5">Porciones:</p>
                                        </div>
                                        <div class="col-12">
                                            <select class="custom-select" name="size" id="inputGroupSelect01">
                                                <option selected>...</option>
                                                <option value="grande">Grande</option>
                                                <option value="mediano">Mediano</option>
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <div class="col-12">
                                            <p class="h5">Especificaciones:</p>
                                        </div>
                                        <div class="col-12">
                                                <textarea class="form-control" name="specs"
                                                          id="exampleFormControlTextarea1" rows="3"
                                                          placeholder="Personalice su orden."></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <p class="h5">Cantidad:</p>
                                        </div>
                                        <div class="col-12">
                                            <select class="custom-select" name="cantidad" id="inputGroupSelect01" required>
                                                <option selected value="">...</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                            <input type="hidden" name="platillo" min="0" max="10"
                                                   value="<?php echo $row['platillo'] ?>" class="form-control"
                                                   id="inputCity" placeholder="0">
                                            <input type="hidden" name="usuario" value="<?php echo $USR ?>"
                                                   class="form-control" id="inputCity" placeholder="0">
                                            <input type="hidden" name="mesa" value="<?php echo $MSA ?>"
                                                   class="form-control" id="inputCity" placeholder="0">
                                            <input type="hidden" name="costo" min="0" max="10"
                                                   value="<?php echo $row['precio'] ?>" class="form-control"
                                                   id="inputCity" placeholder="0">
                                            <input type="hidden" name="status" min="0" max="10" value="Comanda"
                                                   class="form-control" id="inputCity" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <?php
                                      require 'z_connect.php';
                                      if ($row['guarniciones'] != "") {
                                        ?>
                                          <div id="guarciones-section">
                                              <div class="col-12">
                                                  <p class="h5">Guarniciones:</p>
                                              </div>
                                              <div class="col-12">
                                                <?php
                                                $qryGuarnicion = 'SELECT * FROM guarnicones where id_guarnicion in (' . $row['guarniciones'] . ')';

                                                try {

                                                  $res = mysqli_query($conn, $qryGuarnicion) or die ("error en query $qryGuarnicion" . mysqli_error());
                                                } catch (Exception $e) {
                                                  ?>
                                                    <div class="form-check form-check-inline">
                                                       $e
                                                    </div>
                                                  <?php
                                                }

                                                if ($res->num_rows > 0) {
                                                  $i = 0;
                                                  while ($guarnicion = $res->fetch_assoc()) {
                                                    ?>
                                                      <div class="form-check form-check-inline">
                                                          <label class="form-check-label" style="margin-right: 10px" id="<?php echo $guarnicion["ingrediente"]; ?>" for="guarnicion<?php echo ++$i; ?>">
                                                            <?php echo "$" . $guarnicion["valor"] . " " . $guarnicion["ingrediente"]; ?></label>
                                                          <input class="form-check-input" type="checkbox" id="guarnicion<?php echo $i; ?>" name="guarniciones[]" 
                                                          value="<?php echo $guarnicion["ingrediente"]; ?>">
                                                      </div>
                                                    <?php
                                                  }
                                                }
                                                ?>
                                              </div>
                                          </div>
                                        <?php
                                      }
                                      ?>

                                      <?php

                                      if ($row['extras'] != "") {
                                        ?>
                                          <div class="form-group">
                                              <div class="col-12">
                                                  <p class="h5">Extras:</p>
                                              </div>
                                              <div class="col-12">
                                                <?php
                                                $mysql = ("SELECT * FROM inventarios WHERE extras = 1 and id_inventario in (" . $row['extras'] . ")");
                                                $res = mysqli_query($conn, $mysql) or die ("error en query $mysql" . mysqli_error());
                                                if ($res->num_rows > 0) {
                                                  $j = 0;
                                                  while ($extra = $res->fetch_assoc()) {
                                                    ?>
                                                      <div class="form-check form-check-inline">
                                                          <label class="form-check-label" style="margin-right: 10px" id="<?php echo $extra["producto"]; ?>" for="extra<?php echo ++$j; ?>">
                                                            <?php echo "$" . $extra["precio"] . " " . $extra["producto"]; ?></label>
                                                          <input type="checkbox" id="extra<?php echo $j; ?>" style="" name="extras[]" value="<?php echo $extra["producto"]; ?>">
                                                      </div>
                                                    <?php
                                                  }
                                                }
                                                ?>
                                              </div>
                                          </div>
                                        <?php
                                      }

                                      ?>
                                    </div>
                                    <button type="submit" name="add_to_cart" class="btn btn-outline-info">Agregar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <div class="container">
              <?php echo $success ?>
              <?php echo $error ?>
            </div>
        </div>
        </div>
<br>
<?php require_once('footer.html')?>
</body>

</html>
