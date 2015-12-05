<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 include_once "MysqlConnector.php";
 
class Login
{
	private $connector;
	
	public function __construct($conn) 
	{
		$this->connector = $conn;
	}
	function login()
	{
		// controllo sui parametri di autenticazione inviati
		if( !isset($_POST['username']) || $_POST['username']=="" )
		{
			return "Inserire il nome utente.";
		}
		elseif( !isset($_POST['password']) || $_POST['password'] =="")
		{
			return "Inserire la password.";
		}
		else
		{
			// validazione dei parametri tramite filtro per le stringhe
			$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
			$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
			$password = sha1($password);
			
			// interrogazione della tabella
			$sql="SELECT id_login, username FROM login WHERE username = '$username' AND password = '$password'";
			$auth = $this->connector->query($sql);
			
			// controllo sul risultato dell'interrogazione
			if(mysql_num_rows($auth)>0)
			{
				// chiamata alla funzione per l'estrazione dei dati
				$res =  $this->connector->getObjectResult($auth);
				// creazione del valore di sessione
				$_SESSION['admin']=$res->username;
			}
			else
			{
				$sql="SELECT id_studente, nome, cognome FROM studenti natural join password WHERE cf = '$username' AND password = '$password'";
				$auth = $this->connector->query($sql);
				if(mysql_num_rows($auth)>0)
				{
					// chiamata alla funzione per l'estrazione dei dati
					$res =  $this->connector->getObjectResult($auth);
					// creazione del valore di sessione
					$_SESSION['login']=$res->nome." ".$res->cognome;
					$_SESSION['id_student']=$res->id_studente;
				}
				else 
				{
					return "Il nome utente o la password che hai inserito non sono corretti. Vi ricordiamo che il nome utente si riferisce al vostro codifce fiscale!!!";
				}
			}
  		}
	}
}
?>