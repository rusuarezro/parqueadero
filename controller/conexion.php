<?php


$conn = mysqli_connect("localhost:3306", "nisbeth", "pass12345", "dbjrparking");

// Verificar la conexión
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

