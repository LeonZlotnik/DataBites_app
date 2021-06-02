<?php 

require_once('../z_connect.php');

$sql = "SELECT * FROM clientes";

$result = mysqli_query($conn,$sql);

$html = "<table>
<tr>
    <th scope='col'>#</th>
    <th scope='col'>Mail</th>
    <th scope='col'>Contraseña</th>
    <th scope='col'>Cumpleaños</th>
    <th scope='col'>Registro</th>
</tr>
        ";

while($row = mysqli_fetch_assoc($result)){
    $html .= "<tr>
                <th scope='row'>".$row["id_cliente"]."</th>
                <td>".$row["cliente"]."</td>
                <td>Privado</td>
                <td>".$row["cumple"]."</td>
                <td>".$row["registro"]."</td>
             </tr>";
     $htmil .= "</table>";
}
header('Content-Type:application/xls');
header('Content-Disposition:attachment;filename=Reporte_Clientes_Hijas_de_la_tostada(DataBites).xls');

echo $html;

?>