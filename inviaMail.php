<?php
/*
*	inviaMail.php
*	www.comeusare.it
*	http://bit.ly/btemiH
*	webmaster: Loris
*	mail: redazione@comeusare.it
*/
?>
<?
function ControlloEmail($email){
	$result = eregi("^[_a-z0-9+-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$",$email);
	if($result == false){
		return false;
	}else{
		return true;
	}
}

function sendMail()
{
	if($_POST['campo_email'] == null || $_POST['campo_messaggio'] == null)
	{
		return "Compilare i campi correttamente";
	}
	elseif (ControlloEmail($_POST['campo_email']) == false)
	{
		return "Email non valida";
	}
	else
	{
		$destinatario="sbrandollo@gmail.com";
		$mittente_mail=$_POST['campo_email'];
		$oggetto="";
		$oggetto="".$_POST['campo_oggetto'];
		$messaggio="";
		$intestazioni = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: $mittente_mail";
 
		//invio la mail
		$risultato = mail($destinatario, $oggetto, $messaggio, $intestazioni);
		//reindirizzamento
		if(!$risultato) return "Non è stato possibile inviare il messaggio";
	}
}
?>