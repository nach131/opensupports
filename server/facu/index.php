<?php
require_once('lib.php');
$usuarios = usuariosConTickets();
// nach_print_r($usuarios);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  
  <main>
    <div class="container">
      <div class="row py-5">
        <div class="col">

        <h2>Usuarios con tickets</h2>

        <?php if ( $usuarios->num_rows > 0 ) : ?>
        
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Nº Tickets</th>
                <th scope="col">Ver</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              while($usuario = $usuarios->fetch_assoc() ) : 
              // nach_print_r($usuario);  
            ?>
              <tr>
                <th scope="row"><?php echo $usuario['id']; ?></th>
                <td><?php echo $usuario['name']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td><?php echo $usuario['tickets']; ?></td>
                <td><a class="btn btn-primary" href="usuario.php?id=<?php echo $usuario['id']; ?>">Ver más</a></td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>

        <?php else: ?>

        <h4>No hay usuarios</h4>

        <?php endif; ?>

        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>