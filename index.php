<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
session_start();
define('BASE_PATH',"./");
include(BASE_PATH."config.php");

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$connector = new MySqlConnector();
$connector->connect();

switch ($action)
{
	case 'logout':
		logout();
		break;
	case 'login':
		login();
		break;
	default:
		homepage();
}

$connector->disconnect();

// ================================= DEBUG ===================================


/*
echo "<hr />";
echo "<h2>Debug MYSQL</h2>";
echo $connector->debugToHTML();
echo "<h2>Variabili POST</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

/*
echo "<pre>";
print_r($result);
echo "</pre>";*/

// ================================= FUNZIONI===================================

function logout()
{
	session_destroy();
	header("Location: index.php");
}
function login()
{
	global $connector;
	if (isset($_SESSION['admin']))
	{
		header("Location: admin/");
	}
	else if (isset($_SESSION['login']))
	{
		header("Location: index.php");
	}
	else
	{
		$login = new Login($connector);
		$result['errorMessage'] = $login->login();
		if (!$result['errorMessage']) return login();
		$page = "login.php";
		include_once(BASE_PATH."/template.php");
	}
}
function homepage()
{			
	global $connector;
	global $result;
	
	if (isset($_SESSION['admin']))
	{
		header("Location: admin/");
	}
	if (isset($_SESSION['login']))
	{							
		include_once("classes/Student.php");
		include_once("classes/Exam.php");
		include_once("classes/Plan.php");
		include_once("classes/Payment.php");
		include_once("classes/Notice.php");
		include_once("classes/Booking.php");
		include_once("classes/Document.php");
		
		
		$student = new Student();
		$student->setConnector($connector);
		$student = $student->getById($_SESSION['id_student']);
		$student->setConnector($connector);
		
		$exam = new Exam();
		$plan = new Plan();
		$payment = new Payment();
		$notice = new Notice();
		$booking = new Booking();
		$document = new Document();
		
		$exam->setConnector($connector);
		$plan->setConnector($connector);
		$payment->setConnector($connector);
		$notice->setConnector($connector);
		$booking->setConnector($connector);
		$document->setConnector($connector);
		
		if (isset($_POST['operation']))
		{
			list($operation, $params) = explode("#",$_POST['operation']);
	
			switch ($operation)
			{
				case 'editChanges':
					$student->storeFormValues($_POST);
					$student->id=$params;
					if (isset($_POST['password']) && $_POST['password']!='')
					{
						$student->generatePassword($_POST['password']);
					}
					$error_msg = $student->update();
					break;
				case 'saveBook':
					$error_msg=$booking->saveBooking($student->id, $params);
					break;
				case 'sendMail':
					$error_msg=sendMail();
					break;
				default:
					$error_msg = $operation."#".$params;
					break;
			}
			if ($error_msg!="") $result["errorMessage"]=$error_msg;
			elseif ($operation!='edit' && $operation!="nextPage") $result["statusMessage"] = "Operazione completata!";
		}
		
		if ($student) 
		{
			$result["edit"]=$student;
			$result["edit"]->exam = $exam->getList($student);
			$result["edit"]->plan = $plan->getById($student->id_plan);
			$result['edit']->payment = $payment->getById($student->id);
			$result['edit']->notice = $notice->getList();
			$result['edit']->booking = $booking->getListForStudent($student);
			$result['edit']->booked= $booking->getBookedList($student->id);
			$result['edit']->document = $document->getList();
		}
		
		$page = "home.php";
		include_once(BASE_PATH."/template.php");
	}
	else
	{
		$page = "login.php";
		include_once(BASE_PATH."/template.php");
	}
}

/*****************************************************************************************
 * FUNZIONI DI SERVIZIO
 *****************************************************************************************/
 
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
		$destinatario="";
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


 
 