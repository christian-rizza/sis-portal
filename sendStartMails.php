<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
session_start();
define('BASE_PATH',"./");
include(BASE_PATH."config.php");

if (!isset($_SESSION['admin']))
{
	header("Location: index.php");
}

$conn = new MysqlConnector();
$conn->connect();
$student = new Student();
$student->setConnector($conn);

$lista = $student->getList();

foreach ($lista as $entry)
{
		//if ($entry->email=="sbrandollo@gmail.com")
		{
			echo "Email: ".$entry->email." ";
			$entry->setConnector($conn);
			if ($entry->generatePassword())
			{
				echo "[Errore di invio] <br>";	
			}
			else
			{
				echo "[OK] <br>";
			}
		}
		
		$counter++;
}

$conn->disconnect();


?>


