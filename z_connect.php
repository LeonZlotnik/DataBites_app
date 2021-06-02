<?php
$conn = mysqli_connect("p3plzcpnl454185","databases","Data3ites!","h_tostada") or die("error en conexion ".mysqli_connect_error());
    $conn->set_charset("utf8");
         if($conn -> connect_erro){
             die("La Conexion Fallo: ".$conn-> connect_error);
         }
?>