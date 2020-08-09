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
  <title>Tickets Usuarios</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  
  <main>
    <div class="container">
      <div class="row py-5">
        <div class="col">

        <h2 class="h4 bg-warning mb-0 p-4 rounded-top">Tickets del usuario <?php echo $_GET['id']; ?></h2>

        <?php if ( $tickets->num_rows > 0 ) : ?>
        
          <table class="table table-striped table-hover ">
            <thead class="thead-bg">
              <tr>
                <th class="table-header" scope="col">Nº Ticket</th>
                <th class="table-header" scope="col">Título</th>
                <th class="table-header" scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($ticket = $tickets->fetch_assoc() ) : 
              // nach_print_r($ticket);  
              $idsTicketsAFacturar[] = $ticket['id'];
              $fechaApertura = date('Y-m-d', strtotime($ticket['date']));
              // nach_print_r($fechaApertura);  

            ?>
              <tr>
                <th scope="row"><?php echo $ticket['ticket_number']; ?></th>
                <td >
                  
                  <?php echo $ticket['title']; ?>
                  <?php echo $ticket['closed']; ?>


              </span>
              </td>
                <td><?php echo $fechaApertura; ?></td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>

        <?php else: ?>

        <h4 class="bg-noticket p-4 text-center rounded-bottom">Este usuario no tiene tickets.</h4>

        <?php endif; ?>

        </div>
      </div>

      <div class="row py-5">
        <div class="col">

        <h2 class="h4 bg-warning mb-0 p-4 rounded-top" >Pendientes a facturar.</h2>
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
            nach_print_r($ticketEvent);
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


        <table class="table table-striped table-hover">
            <thead class="thead-bg">
              <tr>
                <th class="table-header" scope="col">Nº Ticket</th>
                <th class="table-header" scope="col">Inicio</th>
                <th class="table-header" scope="col">Fin</th>
                <th class="table-header" scope="col">Tiempo</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              foreach ($intervalos as $ticketNumber => $intervalo) :
                $inicio = date('Y-m-d H:i', strtotime($intervalo['ASSIGN']));
                $fin = date('Y-m-d H:i', strtotime($intervalo['CLOSE']));
                $inicioHora = date('H:i', strtotime($intervalo['ASSIGN']));
                $finHora = date('H:i', strtotime($intervalo['CLOSE']));
                // $tiempoHoras = $finHora - $inicioHora;

                $dateInicio = new DateTime($inicio);
                $dateFin = new DateTime($fin);
                $tiempoTotal = date_diff($dateFin, $dateInicio);


                // nach_print_r($inicioHora);
                // nach_print_r($finHora);
                // nach_print_r($tiempoHoras) ;
                // nach_print_r($tiempoTotal->format('%h:%i')) ;


            ?>
              <tr>
                <th scope="row"><?php echo $ticketNumber; ?></th>
                <td><?php echo $inicio; ?></td>
                <td><?php echo $fin; ?></td>
                <td><?php echo $tiempoTotal->format('%h:%i'); ?></td>
              </tr>
            <?php endforeach; ?>
            <tfoot>
              <tr>
                <td colspan="3">Tiempo invertido (en horas)</td>
                <!-- <td><?php echo $tiempo_invertido / 3600; ?></td> -->
                <td><?php echo date('H:i', $tiempo_invertido); ?></td>
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