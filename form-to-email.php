<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email))
{
    echo "Nick y Email son necesarios.";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Email invalido!";
    exit;
}

$email_from = 'admin@ericbatista.com';//<== update the email address
$email_subject = "Solicitud de Bot de #IRCBot";
$email_body = "Tiene un nuevo correo de USUARIO: $name \n".
    "Estos son los datos del Formulario deL USUARIO: $name \n Mensaje: $message \n Nick: $name \n Email de Registro: $visitor_email \n Recibido desde: ".

$to = "admin@ericbatista.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>
