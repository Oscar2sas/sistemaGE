<?php 

	class ConexionDB{

		public function retornar_conexion(){
			try {

				$user = "root";
				$pass = "";
				$host = "localhost";//Solo si es el localhost
				$db = "db_escuela";
				$conexion = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
				
			
			} catch (Exception $e) {

				$conexion=$e->getMessage(); 

			}				
			
			if (!is_object($conexion)){
				// es un error no es un objeto database
				echo $conexion;
				echo "<br> NO SE PUEDE CONECTAR A LA BASE DE DATOS";
				die();
			
			}
			

			return $conexion;

		}
		
		public function cerrar_conexion(&$conexion){
	
			$conexion = null;
			
			return null;
		}		


	}

 ?>