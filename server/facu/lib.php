<?php

function nach_print_r($contenido) {
  echo '<pre>';
  print_r($contenido);
  echo '</pre>';
}

function bbddConnect() {
  $conn = mysqli_connect("192.168.1.126", "nacho", "klingon", "soporte");
  return $conn;
}

function bbddClose($conn) {
  mysqli_close($conn);
}

function usuariosConTickets() {
  $conn = bbddConnect();

  $sql = 'SELECT * FROM `user` WHERE `tickets` > 0';
  $result = $conn->query($sql);

  return $result;
}

function usuariosPorEmail($extensionEmail) {
  $conn = bbddConnect();

  $sql = 'SELECT * FROM `user` WHERE `email` LIKE "%' . $extensionEmail . '"';
  $result = $conn->query($sql);

  return $result;
}

function ticketsPorUsuarioID($idUsuario) {
  $conn = bbddConnect();

  $sql = 'SELECT * FROM `ticket` WHERE `author_id` IN (' . $idUsuario . ')';
  $result = $conn->query($sql);

  return $result;
}

function ticketAsignadosYCerradosPorID($idTicket) {
  $conn = bbddConnect();



  $sql = 'SELECT t.id id_ticket, t.ticket_number, t.date date_created, te.* 
          FROM `ticket` t
            LEFT JOIN `ticketevent` te ON t.id = te.ticket_id
            WHERE 
              te.type IN ("ASSIGN", "CLOSE")
                AND
                t.id IN (' . $idTicket . ')
            ORDER BY 
              te.id ASC';
  $result = $conn->query($sql);

  return $result;
}

