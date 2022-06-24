<?php
$servidor = "127.0.0.1";
$usuario = "root";
$password = "";
$db = "db_escuela";
$conexion = mysqli_connect($servidor,$usuario,$password,$db) or die(mysqli_error());
?>