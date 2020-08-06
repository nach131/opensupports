<?php
require_once('lib.php');
// nach_print_r($_GET);
$tickets = ticketsPorUsuarioID($_GET['id']);
// nach_print_r($tickets);
$idsTicketsAFacturar = array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  

<!-- <?php
$fecha = new DateTime('2000-01-01 12:21');
$fecha->add(new DateInterval('P20D'));
echo $fecha->format('Y-m-d H:i:s') . "\n";
?> -->

<?php
$fecha = date_create('12:21:00');
$suma = date_create('00:31:00');
date_add($fecha, date_interval_create_from_date_string($suma));
echo date_format($fecha, 'H:i:s');

nach_print_r($fecha);
nach_print_r($suma);

?>
</body>
</html>

