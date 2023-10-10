<?php

require_once("./inc/settings.php");
require_once("./inc/functions.php");
connect_database();

$query = "SELECT * FROM `program`   ";
$result = send_mysql_query_no_param($query);


while ($line = $result->fetch(PDO::FETCH_ASSOC)) {
  $email = $line['presenter_email'];


  if (strpos($email, '@') !== false) {
    $pars = array(':email' => get_token($email), ':id_program' => $line['id_program']);
    $query = "UPDATE program SET presenter_email=:email WHERE id_program=:id_program";
    $done = send_mysql_query($query, $pars);
  }
}

?>