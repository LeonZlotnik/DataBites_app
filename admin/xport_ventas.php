<?php 

require_once('../z_connect.php');

$totalExtra =0;
$totalGuanicion = 0;

$sql = "SELECT *, (costo*cantidad) AS subtotal, ((costo*cantidad)*0.16) AS iva, ((costo*cantidad)*0.025) AS fee, ((costo*cantidad)/1.18) AS total FROM comandas WHERE status ='Pagado'";

$result = mysqli_query($conn,$sql);

$html = "<table>
<tr>
    <th scope='col'>Usuario</th>
    <th scope='col'>No. Mesa</th>
    <th scope='col'>Plato</th>
    <th scope='col'>Costo</th>
    <th scope='col'>Cantidad</th>
    <th scope='col'>Subtotal</th>
    <th scope='col'>IVA</th>
    <th scope='col'>Fee</th>
    <th scope='col'>Ingreso Final</th>
    <th scope='col'>Especificaciones</th>
    <th scope='col'>Guarniciones</th>
    <th scope='col'>Extras</th>
    <th scope='col'>Registro</th>
</tr>
        ";

while($row = mysqli_fetch_assoc($result)){
    if($row["extras"]!=null) {
        $sqlExtras = "SELECT sum(precio) total from inventarios where producto in ('" . $row["extras"] . "')";
        $resultExtra = $conn->query($sqlExtras) or die ("error en query $sqlExtras" . mysqli_error());
        if ($resultExtra->num_rows > 0) {
            while ($rowExtra = mysqli_fetch_assoc($resultExtra)) {
                $totalExtra = $rowExtra["total"];
            }
        }
    }
    else{
        $totalExtra =0;
    }
    if($row["guarniciones"]!=null){
        $sqlGuarniciones="SELECT sum(valor) total from guarnicones where ingrediente in ('".$row["guarniciones"]."')";
        $resultGuarniciones = $conn-> query($sqlGuarniciones) or die ("error en query $sqlGuarniciones".mysqli_error());
        if($resultGuarniciones->num_rows>0){
            while($rowGuarnicion = mysqli_fetch_assoc($resultGuarniciones)) {
                $totalGuanicion = $rowGuarnicion["total"];
            }
        }
    }
    else{
        $totalGuanicion = 0;
    }
    $precioTotal = $row["costo"] + $totalExtra + $totalGuanicion;
    $final = $precioTotal*$row["cantidad"];

    $iva = number_format($row["iva"], 2, '.', '');
    $fee = number_format($row["fee"], 2, '.', '');
    $total = number_format($row["total"], 2, '.', '');

    $html .= "<tr>
                <th scope='row' class='user'>".$row["usuario"]."</th>
                <td>#".$row["mesa"]."</td>
                <td>".$row["platillo"]."</td>
                <td>$".$precioTotal."</td>
                <td>".$row["cantidad"]."</td>
                <td>$".$final."</td>
                <td>$".$iva."</td>
                <td>$".$fee."</td>
                <td>$".$total."</td>
                <td>".$row["specs"]."</td>
                <td>".$row["guarniciones"]."</td>
                <td>".$row["extras"]."</td>
                <td>".$row["registro"]."</td>
             </tr>";
     $htmil .= "</table>";
}
header('Content-Type:application/xls');
header('Content-Disposition:attachment;filename=Reporte_Ventas_Hijas_de_la_tostada(DataBites).xls');

echo $html;

?>