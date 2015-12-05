<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

class Exam
{
	//Generale
	public $id_student;
	public $id_subject;
	public $vote;
	public $date;
	
	//Informazioni di servizio
	public $year;
	public $subject_name;
	
	private $connector;
			
	public function __construct($data=array()) 
	{
		
		if ( isset( $data['id_studente'] ) && $data['id_studente']!="") $this->id_student = trim((int)$data['id_studente']);
		if ( isset( $data['voto'] ) && $data['voto']!="") $this->vote = trim((int) $data['voto']);
		if ( isset( $data['id_materia'] ) && $data['id_materia']!="") $this->id_subject = trim((int)$data['id_materia']);
		if ( isset( $data['data_esame'] ) && $data['data_esame']!="") $this->date = trim($data['data_esame']);
	}
	public function setConnector($conn)
	{
		$this->connector=$conn;
	}
	
	public function storeFormValues($params) {
		$this->__construct( $params );
	}
	
	public function validate() {
		
		if (!$this->id_student) return "Studente non valido";
		if (!$this->vote) return "Voto non valido";
		if (!$this->id_subject) return "Materia non valida";
		if (!$this->date) return "Data non valida";
	}
	
	public function insert() {
		
		if ($validation = $this->validate()) return $validation;
		
		$tabella = "esami";	
		$valori = array($this->id_student,$this->id_subject, $this->vote, $this->date);
		$campi = array("id_studente","id_materia","voto","data_esame");
		$auth = $this->connector->insert($tabella, $campi, $valori);
		
		if (mysql_errno()==1062) return "Esame già sostenuto, impossibile resistrarlo";
		else if (mysql_errno()>0) return "Errore interno numero: ".mysql_error();
	}
	public function update()
	{
		if ($validation = $this->validate()) return $validation;				
						
	    $sql = "UPDATE esami SET voto='$this->vote',data_esame='$this->date' WHERE id_studente='$this->id_student' and id_materia=$this->id_subject";
	    $auth = $this->connector->query($sql);
	
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno()." ".mysql_error();
	}
	public function getById($student_id,$subject_id)
	{		
		// interrogazione della tabella
		$sql="SELECT * FROM esami WHERE id_studente='$student_id' and id_materia='$subject_id'";
		$auth = $this->connector->query($sql);
		$exam;
		if(mysql_num_rows($auth)>0)
		{
			$res =  $this->connector->getObjectResult($auth);
			$exam = new Exam(get_object_vars($res));
		}
				
		if ($exam) return $exam;
		
	}
	public function getList($studend) 
	{	
		// interrogazione della tabella
		$sql="SELECT * FROM esami WHERE id_studente='$studend->id'";
		$auth = $this->connector->query($sql);
		
		$list=array();	
		if(mysql_num_rows($auth)>0)
		{
			while ($res =  $this->connector->getObjectResult($auth))
			{
				$exam = new Exam(get_object_vars($res));
				
				//Calcolo le informazioni di servizio
				$plan = new Plan();
				$plan->setConnector($this->connector);
				$student_plan = $plan->getById($studend->id_plan);
				
				foreach ($student_plan->subjects as $subj)
				{
					if($exam->id_subject==$subj->subject_id)
					{
						$exam->year = $subj->year;
						break;
					}
				}
				
				$subject = new Subject();
				$subject->setConnector($this->connector);
				$exam->subject_name = $subject->getById($exam->id_subject)->name;
				
				$list[] = $exam;
			}
		}
		
		return $list;
	}
	public function delete($id_stud,$id_mat) 
	{			
		$sql="DELETE FROM esami WHERE id_studente = $id_stud and id_materia = $id_mat";
		
		$auth = $this->connector->query($sql);
		
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
}