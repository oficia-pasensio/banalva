<?php 
$Mes_anterior = date("Y") . "/" . date('m', strtotime('-1 month')) . "/" . date("d");
$fecha =  date ("Y") . "/" . date("m") . "/" . date("d");
echo "FECHA ACTUAL : " . $fecha;
echo "FECHA MES ANTERIOR : " . $Mes_anterior;
?>	