<?php


$conn = mysqli_connect("localhost", "Ruben", "S3creto123", "dbjrparking");

// Verificar la conexión
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

