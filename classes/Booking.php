<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
 
class Booking
{
	public $id;
	public $plan_id;
	public $subject_id;
	public $year;
	public $docente;
	public $exam_date;
	
	//Informazioni di servizio
	public $course_name;
	public $plan_code;
	public $subject_name;
	public $book_date;
	public $book_id;
	public $student_id;
	public $student;
	private $connector;
	
	public function __construct($id, $plan_id, $subject_id, $year, $docente, $exam_date)
	{
		$this->id=$id;
		$this->plan_id=$plan_id;
		$this->subject_id = $subject_id;
		$this->year = $year;
		$this->docente = $docente;
		$this->exam_date = $exam_date;
	}
	public function setConnector($connector)
	{
		$this->connector = $connector;
	}
	public function insert()
	{
		
		if (!$this->plan_id) return "Selezionare il piano di studi";
		if (!$this->subject_id) return "Selezionare la materia"; 
		if (!$this->docente) return "Inserire il docente";
		if (!$this->exam_date) return "Inserire una data valida";
		
		$tabella = "appelli";
		$campi = array("id_piano","id_materia","anno","docente","data_esame");
		$valori = array($this->plan_id,$this->subject_id, $this->year, $this->docente, $this->exam_date);
	
		$auth = $this->connector->insert($tabella, $campi, $valori);
		if (mysql_errno()==1062) return "Appello già attivo";
		else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function delete($id)
	{
		//Controllo l'id
		$id = (int)$id;		
		$sql = "DELETE FROM appelli WHERE id_appello = $id";
		$auth = $this->connector->query($sql);
		
		if (mysql_errno()==1451) return "Esistono delle prenotazioni attive per quest'appello ed è impossibile eliminarlo. ";
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function deleteBooked($id)
	{
		//Controllo l'id
		$id = (int)$id;		
		$sql = "DELETE FROM prenotazioni WHERE id_prenotazione = $id";
		$auth = $this->connector->query($sql);
		
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_error();
	}
	public function update()
	{
		if (!$this->id) return "Non è stato possibile trovare l'appello, contattare il fornitore!";
		if (!$this->plan_id) return "Selezionare il piano di studi";
		if (!$this->subject_id) return "Selezionare la materia"; 
		if ($this->year) return "Selezionare l'anno";
		if (!$this->docente) return "Inserire il docente";
		if (!$this->exam_date) return "Inserire una data valida";
				
		$table = "appelli";
		$field = array("id_piano","id_materia","anno","docente");
		$value = array($this->plan_id, $this->subject_id,$this->year, $this->docente, $this->exam_date);
		$field_com = array("id_appello");
		$value_com = array($this->id);
		
		$auth = $this->connector->update($table, $field, $value, $field_com, $value_com);
		
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function getList($order="data_esame")
	{
		$order = trim(filter_var($order,FILTER_SANITIZE_STRING));
		
		//interrogazione tabella
		$sql="SELECT * FROM appelli ORDER BY $order";
		$auth = $this->connector->query($sql);
		
		$list=array();
		// controllo sul risultato dell'interrogazione
		if(mysql_num_rows($auth)>0)
		{
			$plan = new Plan();
			$plan->setConnector($this->connector);
			$subject = new Subject();
			$subject->setConnector($this->connector);
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$book = new Booking($res->id_appello, $res->id_piano, $res->id_materia, $res->anno, $res->docente, $res->data_esame);
				
				//Calcolo le informazioni di servizio
				$currPlan = $plan->getById($book->plan_id);
				$book->course_name = $currPlan->course_name;
				$book->plan_code = $currPlan->plan_code;
				$book->subject_name = $subject->getById($book->subject_id)->name;
								
				$list[] = $book;
			}
		}
		return $list;
	}
	public function getById($id)
	{
		$id = (int)$id;
		$sql="SELECT * FROM appelli WHERE id_appello= $id";
		$auth = $this->connector->query($sql);
		
		$plan = new Plan();
		$plan->setConnector($this->connector);
		$subject = new Subject();
		$subject->setConnector($this->connector);
		if(mysql_num_rows($auth)>0)
		{
			// chiamata alla funzione per l'estrazione dei dati
			$res =  $this->connector->getObjectResult($auth);
			$book = new Booking($res->id_appello, $res->id_piano, $res->id_materia, $res->anno, $res->docente, $res->data_esame);
			
			//Calcolo le informazioni di servizio
			$currPlan = $plan->getById($book->plan_id);
			$book->course_name = $currPlan->course_name;
			$book->plan_code = $currPlan->plan_code;
			$book->subject_name = $subject->getById($book->subject_id)->name;
			
			return $book;
		}
		return false;
	}
	public function storeFormValues($data)
	{
		if ( isset( $data['id_appello'] ) && $data['id_appello']!="") $id = (int) $data['id_appello'];
		if ( isset( $data['id_piano'] ) && $data['id_piano']!="") $plan_id = (int) $data['id_piano'];
		if ( isset( $data['id_materia'] ) && $data['id_materia']!="") 
		{
			$value = explode("#",$data['id_materia']);
			$subject_id = $value[0];
			$year = $value[1];
		}
		if ( isset( $data['docente'] ) && $data['docente']!="") $docente = trim(filter_var($data['docente'], FILTER_SANITIZE_STRING));
		if ( isset( $data['data_esame'] ) && $data['data_esame']!="") $exam_date = trim(filter_var($data['data_esame'], FILTER_SANITIZE_STRING));
		
		
		$this->__construct($id, $plan_id, $subject_id, $year , $docente, $exam_date);
	}
	public function saveBooking($student_id, $session_id)
	{
		$tabella= "prenotazioni";
		$data = date("d/m/Y");
		
		$campi = array("id_appello","data_prenotazione","id_studente");
		$valori = array($session_id,$data,$student_id);
		
		$this->connector->insert($tabella, $campi, $valori);
		if (mysql_errno()==1062) return "Esame già prenotato";
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function getListForStudent($student, $order="data_esame")
	{
		$order = trim(filter_var($order,FILTER_SANITIZE_STRING));
		
		//interrogazione tabella
		$sql="select * from appelli where id_piano = '$student->id_plan' and id_appello not in (select id_appello from prenotazioni where id_studente = '$student->id') ORDER BY $order";
		$auth = $this->connector->query($sql);
		
		$list=array();
		// controllo sul risultato dell'interrogazione
		if(mysql_num_rows($auth)>0)
		{
			$plan = new Plan();
			$plan->setConnector($this->connector);
			$subject = new Subject();
			$subject->setConnector($this->connector);
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$book = new Booking($res->id_appello, $res->id_piano, $res->id_materia, $res->anno, $res->docente, $res->data_esame);
				
				//Calcolo le informazioni di servizio
				$currPlan = $plan->getById($book->plan_id);
				$book->course_name = $currPlan->course_name;
				$book->plan_code = $currPlan->plan_code;
				$book->subject_name = $subject->getById($book->subject_id)->name;
				$list[] = $book;
			}
		}
		return $list;
	}
	public function getBookedList($student_id=null, $order="data_prenotazione")
	{
		$order = trim(filter_var($order,FILTER_SANITIZE_STRING));
		$id = (int) $student_id;
		
		//interrogazione tabella
		if ($id)
			$sql="SELECT * FROM prenotazioni WHERE id_studente='$id' ORDER BY $order";
		else
			$sql="SELECT * FROM prenotazioni ORDER BY $order";
		
		$auth = $this->connector->query($sql);
		$list=array();
		
		$student = new Student();
		$student->setConnector($this->connector);
		
		// controllo sul risultato dell'interrogazione
		if(mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$book = $this->getById($res->id_appello);
				$book->book_date = $res->data_prenotazione;
				$book->student_id = $res->id_studente;
				$book->book_id = $res->id_prenotazione;
				$book->student = $student->getById($book->student_id);
				$list[] = $book;
			}
		}
		return $list;
	}
}