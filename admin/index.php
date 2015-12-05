<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

session_start();
define('BASE_PATH',"../");
include(BASE_PATH."config.php");

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$connector = new MySqlConnector();
$connector->connect();
$result;

$module = isset( $_GET['module'] ) ? $_GET['module'] : "";

switch ( $module )  
{	
	case 'course':
		showCourse();
		break;
	case 'subject':
		showSubject();
		break;
	case 'plan':
		showPlan();
		break;
	case 'student':
		showStudent();
		break;
	case 'exam':
		showExam();
		break;
	case 'payment':
		showPayment();
		break;
	case 'booking':
		showBooking();
		break;
	case 'booked':
		showBooked();
		break;
	case 'notice':
		showNotice();
		break;
	case 'docs':
		showDocs();
		break;
	case null:
    	homepage();
		break;
	default:
		errorpage();
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
// ================================= FUNZIONI ===================================

function showBooked()
{
	global $connector;
	$booking = new Booking();
	$booking->setConnector($connector);
	
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		switch ($operation)
		{
			case 'delete':
				$error_msg = $booking->deleteBooked($params);
				break;
			
			default:
				$error_msg = "Operazione non valida";
		}
		
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit') $result["statusMessage"] = "Operazione completata!";
		
	}
	
	$result['booked'] = $booking->getBookedList();
	$page = "booked.php";
	include_once(BASE_PATH."template.php");
}
function showDocs()
{
	global $connector;
	global $result;
	
	$course = new Course();
	$doc = new Document();
	$course->setConnector($connector);
	$doc->setConnector($connector);
	
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		switch ($operation)
		{
			case 'saveChanges':
				$doc->storeFormValues($_POST, BASE_PATH."/upload/");
				$error_msg = $doc->insert();
				break;
			case 'delete':
				$error_msg = $doc->delete($params);
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit') $result["statusMessage"] = "Operazione completata!";
		
	}
	$result["courses"]=$course->getList("nome");
	$result['docs'] = $doc->getList();
	$page = "document.php";
	include_once(BASE_PATH."template.php");
}
function showNotice()
{
	global $connector;
	global $result;
	
	$notice = new Notice();
	$notice->setConnector($connector);
	$student = new Student();
	$student->setConnector($connector);
	
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		switch ($operation)
		{
			case 'saveChanges':
				$notice->storeFormValues($_POST);
				$error_msg = $notice->insert();
				break;
			case 'delete':
				$error_msg = $notice->delete($params);
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit') $result["statusMessage"] = "Operazione completata!";
		
	}
	$result['students'] = $student->getList();
	$result['notices'] = $notice->getList();
	$page = "notice.php";
	include_once(BASE_PATH."template.php");
}
function showBooking()
{
	global $connector;
	
	$course = new Course();
	$course->setConnector($connector);
	
	$plan = new Plan();
	$plan->setConnector($connector);
	
	$booking = new Booking();
	$booking->setConnector($connector);
	
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		switch ($operation)
		{
			case 'getAjaxPlanList':
				echo $plan->getAjaxList($params, "nome");
				return;
			case 'saveChanges':
				$booking->storeFormValues($_POST);
				$error_msg = $booking->insert();
				break;
			case 'delete':
				$error_msg = $booking->delete($params);
				break;
			
			default:
				$error_msg = "Operazione non valida";
		}
		
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit') $result["statusMessage"] = "Operazione completata!";
		
	}
	$result['courses'] = $course->getList("nome");
	$result['booked'] = $booking->getList();
	
	$page = "booking.php";
	include_once(BASE_PATH."template.php");
}
function showPayment()
{
	global $connector;
	
	$student = new Student();
	$student->setConnector($connector);
	
	$payment = new Payment();
	$payment->setConnector($connector);	
	
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		
		switch ($operation)
		{
			
			case 'selectStudent':
				$result['edit'] = $payment->getById($params);
				if (!isset($result['edit']->student_id))
				$result['edit']->student_id = $params;
				break;
			case 'delete':
				$error_msg = $payment->delete($params);
				break;
			case 'edit':
				$result['edit'] = $payment->getById($params);
				break;
			case 'editChanges':	
				$payment->storeFormValues($_POST);
				$error_msg = $payment->update();
				break;
			case 'saveChanges':
				$payment->storeFormValues($_POST);
				$payment->setConnector($connector);
				$error_msg = $payment->insert();
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit' && $operation!='selectStudent') $result["statusMessage"] = "Operazione completata!";
	}
	
	$result['students'] = $student->getList("cognome");
	$result['payments'] = $payment->getList();
	$page = "payment.php";
	include_once(BASE_PATH."template.php");
}
function showExam()
{
	global $connector;
	
	$student = new Student();
	$plan = new Plan();
	$course = new Course();
	$subject = new Subject();
	$exam = new Exam();
	$student->setConnector($connector);
	$plan->setConnector($connector);
	$course->setConnector($connector);
	$subject->setConnector($connector);
	$exam->setConnector($connector);
	
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		
		switch ($operation)
		{
			case 'selectStudent':
				$stud = $student->getById($_POST['id_studente']);
				$studentPlan = $plan->getById($stud->id_plan);
				
				$result['edit']->student=$stud;
				$result['edit']->planList = $studentPlan;
				$result['edit']->exam = $exam->getList($stud);
				
				break;
			case 'delete':
				$error_msg = $exam->delete($_POST['id_studente'],$params);
				$stud = $student->getById($_POST['id_studente']);
				$studentPlan = $plan->getById($stud->id_plan);
				
				$result['edit']->student=$stud;
				$result['edit']->planList = $studentPlan;
				$result['edit']->exam = $exam->getList($stud);
				break;
			case 'edit':
				$stud = $student->getById($_POST['id_studente']);
				$studentPlan = $plan->getById($stud->id_plan);
				
				$curr_exam = $exam->getById($stud->id, $params);
				$result['edit']->subject_id = $curr_exam->id_subject;
				$result['edit']->vote = $curr_exam->vote;
				$result['edit']->date = $curr_exam->date;
				
				$result['edit']->student=$stud;
				$result['edit']->planList = $studentPlan;
				$result['edit']->exam = $exam->getList($stud);
				break;
			case 'editChanges':
				$exam->storeFormValues($_POST);
				$error_msg = $exam->update();
				
				$stud = $student->getById($_POST['id_studente']);
				$studentPlan = $plan->getById($stud->id_plan);
				$result['edit']->student=$stud;
				$result['edit']->planList = $studentPlan;
				$result['edit']->exam = $exam->getList($stud);
				
				break;
			case 'saveChanges':
				$exam->storeFormValues($_POST);
				$error_msg = $exam->insert();
				
				$stud = $student->getById($_POST['id_studente']);
				$studentPlan = $plan->getById($stud->id_plan);
				$result['edit']->student=$stud;
				$result['edit']->planList = $studentPlan;
				$result['edit']->exam = $exam->getList($stud);
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit' && $operation!='selectStudent') $result["statusMessage"] = "Operazione completata!";
	}
	
	$result["students"]=$student->getList("cognome");
	$page = "exam.php";
	include_once(BASE_PATH."template.php");
}
function showStudent()
{
	global $connector;
	global $result;
	
	$student = new Student();
	$course = new Course();
	$plan = new Plan();
	$student->setConnector($connector);	
	$course->setConnector($connector);
	$plan->setConnector($connector);
	
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		
		switch ($operation)
		{
			case 'delete':
				$error_msg = $student->delete($params);
				break;
			case 'edit':
				$stud = $student->getById($params);
				$result['edit'] = $stud;
				$result['edit']->student = $stud;
				
				$exam = new Exam();
				$exam->setConnector($connector);
				$result['edit']->exam = $exam->getList($result['edit']->student);
				break;
			case 'editChanges':
				$student->storeFormValues($_POST);
				$error_msg = $student->update();
				break;
			case 'saveChanges':
				$student->storeFormValues($_POST);
				$error_msg = $student->insert();
				if ($error_msg) $result['edit'] = $student;
				break;
			case 'nextPage':
				$student->storeFormValues($_POST);
				$result['edit'] = $student;
				break;
			case 'createPassword':
				$stud = $student->getById($params);
				$stud->setConnector($connector);
				$error_msg = $stud->generatePassword();
				$result['edit'] = $stud;
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit' && $operation!="nextPage") $result["statusMessage"] = "Operazione completata!";
	}
	
	if (isset($_POST['search'])) $result["students"]= $student->search($_POST['search']);
	else $result["students"]=$student->getList();
	$result["plans"]=$plan->getList("id_piano");
	$result["courses"]=$course->getList("nome");
	$page = "student.php";
	include_once(BASE_PATH."template.php");
}
function showPlan()
{
	global $connector;
	global $result;
	
	$plan = new Plan();
	$plan->setConnector($connector);
	
	$course = new Course();
	$course->setConnector($connector);
	
	$subject = new Subject();
	$subject->setConnector($connector);
	
	if ($_POST['operation'])
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		
		switch ($operation)
		{
			case 'saveChanges':
				$plan->storeFormValues($_POST);
				$error_msg = $plan->insert();
				if ($error_msg) $result['edit'] = $plan;
				break;
			case 'delete':
				$error_msg = $plan->delete($params);
				break;				
			case 'edit':
				$result['edit'] = $plan->getById($params);
				break;
			case 'editChanges':
				$plan->storeFormValues($_POST);
				$error_msg = $plan->update();
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit') $result["statusMessage"] = "Operazione completata!";
	}
	
	$result["courses"]=$course->getList("nome");
	$result["plans"]=$plan->getList("codice");
	$result["subjects"]=$subject->getList("nome");
	
	$page = "plan.php";
	include_once(BASE_PATH."template.php");
}
function showSubject()
{
	global $connector;
	$subject = new Subject();
	$subject->setConnector($connector);
	if (isset($_POST['operation']))
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		
		switch ($operation)
		{
			case 'saveChanges':
				$subject->storeFormValues($_POST);
				$error_msg = $subject->insert();
				if ($error_msg) $result['edit'] = $subject;
				break;
			case 'delete':
				$error_msg = $subject->delete($params);
				break;
			case 'edit':
				$result['edit'] = $subject->getById($params);
				break;
			case 'editChanges':
				$subject->storeFormValues($_POST);
				$error_msg = $subject->update();
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit') $result["statusMessage"] = "Operazione completata!";
	}
	
	if (isset($_POST['search'])) $result["subjects"] = $subject->search($_POST['search']);
	else $result["subjects"]=$subject->getList();
	
	$page = "subject.php";
	include_once(BASE_PATH."template.php");
}
function showCourse()
{
	global $connector;
	$page = "course.php";
	$course = new Course();
	$course->setConnector($connector);
	
	if ($_POST['operation'])
	{
		list($operation, $params) = explode("#",$_POST['operation']);
		
		switch ($operation)
		{
			case 'saveChanges':
				$course->storeFormValues($_POST);
				$error_msg = $course->insert();
				if ($error_msg) $result['edit'] = $course;
				break;
			case 'delete':
				$error_msg = $course->delete($params);
				break;
			case 'edit':
				$result['edit'] = $course->getById($params);
				break;
			case 'editChanges':
				$course->storeFormValues($_POST);
				$error_msg = $course->update();
				break;
			default:
				$error_msg = "Operazione non valida";
		}
		if ($error_msg!="") $result["errorMessage"]=$error_msg;
		elseif ($operation!='edit') $result["statusMessage"] = "Operazione completata!";
	}
		
	if (isset($_POST['search'])) $result["courses"] = $course->search($_POST['search']);
	else $result["courses"]=$course->getList();
	
	$page = "course.php";
	include_once(BASE_PATH."template.php");
}
function homepage()
{
	$page = "admin.php";
	include_once(BASE_PATH."template.php");
}
function errorpage()
{	
	$result["errorMessage"] = "Modulo ancora in fase di sviluppo!";
	$page = "admin.php";
	include_once(BASE_PATH."template.php");
}