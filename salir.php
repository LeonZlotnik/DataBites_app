<?php
    session_start();
    if(isset($_GET['salir'])){
        session_destroy();
        header('location:index.php');
    }else{
        echo "Error";
    }
?>