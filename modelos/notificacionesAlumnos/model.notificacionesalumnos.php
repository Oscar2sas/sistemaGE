<?php 
  // Inclusion de la libreria phpmailer => envio de correos

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include ($absolute_include.'clases/phpmailer/src/Exception.php');
include ($absolute_include.'clases/phpmailer/src/PHPMailer.php');
include ($absolute_include.'clases/phpmailer/src/SMTP.php');

function enviarMensajeNotificacionAlumnos($arg_resultado_notificacion_division_alumnos, $arg_descripcion_mensaje_notificacion_alumnos){

// Load Composer's autoloader
// require 'vendor/autoload.php';
	$mail = new PHPMailer();

	try {
    //Configuracion de servidor

		$mail->SMTPDebug = 0;
		$mail->CharSet = 'UTF-8';                      
	    $mail->isSMTP();                                         // Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = '';                     // SMTP username
	    $mail->Password   = '';                               // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
	    $mail->Port       = 587;
	    $mail->SMTPOptions = array(
	    	'ssl' => array(
	    		'verify_peer' => false,
	    		'verify_peer_name' => false,
	    		'allow_self_signed' => true
	    	)
	    );                                   
	    //Persona que manda y quien recibe
	    $mail->setFrom('', 'Marcos');

	    foreach ($arg_resultado_notificacion_division_alumnos as $key => $division_alumnos) {
	    	$mail->addAddress($division_alumnos['cemail_persona']);    
	    // $mail->addAddress('ellen@example.com');               

	    // Contenido
	    	$mail->isHTML(true);                                 
	    	$mail->Subject = 'Mensaje de la E.P.E.T Nº 7';
	    	$mail->Body    = "$arg_descripcion_mensaje_notificacion_alumnos";
	    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    	$mail->send();
	    }

	    return array('estado' => true,'mensaje' => "Correos enviados con exito!");
	}catch (Exception $e) {
		return array('estado' => false,'mensaje' => "Hubo un error en: {$mail->ErrorInfo}");
	}

}


