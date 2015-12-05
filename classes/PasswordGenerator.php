<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
class PasswordGenerator
{
	public function createPassword()
	{
		$password='';
		$possibleChars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$i=0;
		$length=8;
		for ($i=0;$i<$length;$i++)
		{
			$char = substr($possibleChars, mt_rand(0,strlen($possibleChars)-1),1);
			$password.=$char;
		}
		return $password;
	}
	public function sendPassword($password, $student)
	{
		$destinatario=$student->email;
		$mittente_mail="";
		$oggetto="";
		$messaggio="";
		$intestazioni = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: $mittente_mail";
 
		//invio la mail
		$risultato = mail($destinatario, $oggetto, $messaggio, $intestazioni);
		//reindirizzamento
		return $risultato;
	}
}