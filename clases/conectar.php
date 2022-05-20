<?php
$servidor = 'localhost';
$usuario ='root';
$password = '';
$base_de_datos = 'db_escuela';

mb_internal_encoding("UTF-8");

$mysqli= new MySQLi($servidor, $usuario, $password, $base_de_datos);
if ($mysqli->connect_errno){
echo "No se pudo realizar la conexión: ("
  . $mysqli->connect_errno . ") ". $mysqli->connect_error; 
}
$mysqli->character_set_name();
$mysqli->set_charset("utf8");
?>
