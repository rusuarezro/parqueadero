<?php

//private $db_host = "localhost:3306"; //Lugar o IP donde esta el servidor de Base de datos
//private $db_user = "nisbeth"; // dbRusuarezrO Nombre del usuario para conectarnos a la base de datos 
//private $db_pass = "pass12345"; // rusuarezro123 Contraseña del Usuario de la Base de datos
//private $db_name = "dbjrparking"; // Nombre de la Base de Datos

$conn = mysqli_connect("localhost:3306", "nisbeth", "pass12345", "dbjrparking");

// Verificar la conexión
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
