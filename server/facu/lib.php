<?php

function nach_print_r($contenido) {
  echo '<pre>';
  print_r($contenido);
  echo '</pre>';
}

function bbddConnect() {
  $conn = mysqli_connect("localhost", "nacho", "klingon", "unosoporte");
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
            LEFT JOIN `tag_ticket` tt ON t.id = tt.ticket_id
            LEFT JOIN `ticketevent` te ON t.id = te.ticket_id
            WHERE 
              tt.tag_id != 3
                AND
              te.type IN ("ASSIGN", "CLOSE")
                AND
                t.id IN (' . $idTicket . ')
            ORDER BY 
              te.id ASC';
  $result = $conn->query($sql);

  return $result;
}

// EN PROCESO
function ticketFacturadosPorID($idTicket) {
  $conn = bbddConnect();



  $sql = 'SELECT t.id id_ticket, t.ticket_number, t.date date_created, te.* 
          FROM `ticket` t
            LEFT JOIN `tag_ticket` tt ON t.id = tt.ticket_id
            LEFT JOIN `ticketevent` te ON t.id = te.ticket_id
            WHERE 
              tt.tag_id = 3
                AND
              te.type IN ("ASSIGN", "CLOSE")
                AND
                t.id IN (' . $idTicket . ')
            ORDER BY 
              te.id ASC';
  $result = $conn->query($sql);

  return $result;
}

function TodosTicketPorUsiarioID(){
  $conn = bbddConnect();

  $sql = 'SELECT t.id id_ticket,t.title,t.ticket_number,t.date date_created, te.type,tt.tag_id tag, u.name
  FROM
      `ticket` t
  LEFT JOIN `tag_ticket` tt ON
      t.id = tt.ticket_id
  LEFT JOIN `ticketevent` te ON
      t.id = te.ticket_id
  LEFT JOIN `user` u ON
	t.author_id = u.id
  WHERE
      t.id AND te.type IN("CLOSE")
  ORDER BY
      u.name ASC';
  $result = $conn->query($sql);

    return $result;
}