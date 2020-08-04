<?php
require_once('lib.php');
// nach_print_r($_GET);
$tickets = ticketsPorUsuarioID($_GET['id']);
// nach_print_r($tickets);
$idsTicketsAFacturar = array();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuarios</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  
  <main>
    <div class="container">
      <div class="row py-5">
        <div class="col">

        <h2>Tickets del usuario <?php echo $_GET['id']; ?></h2>

        <?php if ( $tickets->num_rows > 0 ) : ?>
        
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($ticket = $tickets->fetch_assoc() ) : 
              // nach_print_r($ticket);  
              $idsTicketsAFacturar[] = $ticket['id'];
            ?>
              <tr>
                <th scope="row"><?php echo $ticket['ticket_number']; ?></th>
                <td><?php echo $ticket['title']; ?></td>
                <td><?php echo $ticket['date']; ?></td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>

        <?php else: ?>

        <h4>No hay tickets para este usuario.</h4>

        <?php endif; ?>

        </div>
      </div>

      <div class="row py-5">
        <div class="col">

        <h2>Facturacion de tickets</h2>
        <?php
          // nach_print_r($idsTicketsAFacturar);
          $ticketEvents = ticketAsignadosYCerradosPorID(implode(',', $idsTicketsAFacturar));
          // nach_print_r($ticketEvents);

          $intervalos = array();
        ?>

        <?php 
        if ( $ticketEvents->num_rows > 0 ) {
          while($ticketEvent = $ticketEvents->fetch_assoc() ) {
            // $intervalos[$ticketEvent['id_ticket']][$ticketEvent['type']] = $ticketEvent['date'];
            $intervalos[$ticketEvent['ticket_number']][$ticketEvent['type']] = $ticketEvent['date'];
          }
        }
        // nach_print_r($intervalos);
        ?>

        <?php
        // tiempo_invertido en milisegundos
        $tiempo_invertido = 0;

        foreach ( $intervalos as $intervalo ) {
          if ( !isset( $intervalo['CLOSE'] ) ) { continue; }

          $inicio = strtotime($intervalo['ASSIGN']);
          $fin = strtotime($intervalo['CLOSE']);

          $tiempo_invertido = $tiempo_invertido + ($fin - $inicio);
        }
        ?>


        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID Ticket</th>
                <th scope="col">Inicio</th>
                <th scope="col">Fin</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              foreach ($intervalos as $ticketNumber => $intervalo) :
                $inicio = date('Y-m-d H:i', strtotime($intervalo['ASSIGN']));
                $fin = date('Y-m-d H:i', strtotime($intervalo['CLOSE']));
            ?>
              <tr>
                <th scope="row"><?php echo $ticketNumber; ?></th>
                <td><?php echo $inicio; ?></td>
                <td><?php echo $fin; ?></td>
              </tr>
            <?php endforeach; ?>
            <tfoot>
              <tr>
                <td colspan="2">Tiempo invertido (en horas)</td>
                <td><?php echo $tiempo_invertido / 3600; ?></td>
              </tr>
            </tfoot>
            </tbody>
          </table>

        


        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>