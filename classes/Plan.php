<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

class Plan
{
	public $id;					//Contiene l'ide del piano
	public $plan_code;			//Codice personalizzato
	public $course_id;			//ID del corso
	public $subjects;			//Lista delle entry
	
	//Informazioni di servizio
	public $subject_length;
	public $course_name;
	private $connector;
	
	
	public function __construct($id, $plan_code, $course_id, $subject = array())
	{
		$this->id = (int) $id;
		$this->plan_code = $plan_code;
		$this->course_id = (int) $course_id;
		$this->subjects = $subject;
	}
	public function setConnector($conn)
	{
		$this->connector = $conn;
	}
	public function insert()
	{
		if (isset($this->plan_code) && $this->plan_code!="") $this->plan_code = trim(filter_var($this->plan_code,FILTER_SANITIZE_STRING));
		if (isset($this->course_id) && $this->course_id!="") $this->course_id = (int) $this->course_id;	
		
		if (count($this->subjects)<=0) return "Inserire almeno una materia";
		if (!$this->plan_code) return "Inserire il codice del piano di studi";
		if (!$this->course_id) return "Selezionare il corso di studi";
		
		
		$tabella = "piani";
		for ($i=0;$i<count($this->subjects);$i++)
		{		
			if (!$this->id)
			{		
				$valori = array($this->plan_code, $this->course_id, $this->subjects[$i]->subject_id, $this->subjects[$i]->year);
				$campi = array("codice", "id_corso", "id_materia","anno");
				$auth = $this->connector->insert($tabella, $campi, $valori);
				
				//Prelevo l'id appena inserito
				$this->id = $auth;
				
				if (mysql_errno()==1062) return "Una delle materie è gia presente nel piano scelto. Sono state inserite solo le materie valide!";
				else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
			}
			else
			{
				$valori = array($this->id,$this->plan_code, $this->course_id, $this->subjects[$i]->subject_id, $this->subjects[$i]->year);
				$campi = array("id_piano","codice", "id_corso", "id_materia","anno");
				$auth = $this->connector->insert($tabella, $campi, $valori);
				
				if (mysql_errno()==1062) return "Una delle materie è gia presente nel piano scelto. Sono state inserite solo le materie valide!";
				else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
			}
		}
	}
	public function delete($id)
	{		
		// interrogazione della tabella
		$id=(int) $id;
		$sql="DELETE FROM piani WHERE id_piano = '$id'";
		$auth = $this->connector->query($sql);
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function update()
	{
		if ($this->id)
		{
			mysql_query("BEGIN");
			
			$this->delete($this->id);
			$ret = $this->insert();
			
			if ($ret)
			{
				mysql_query("ROLLBACK");
				return "Errore durante l'aggiornamento, l'inserimento è stato annullato<br>".$ret;
			}
			
			mysql_query("COMMIT");
		}
	}
	public function getById($id)
	{
		$id=(int) $id;
		$sql="SELECT * FROM piani WHERE id_piano='$id' LIMIT 1";
		$auth = $this->connector->query($sql);
		
		if(mysql_num_rows($auth)>0)
		{
			//Inializzo le classi di servizio
			$course = new Course();
			$course->setConnector($this->connector);
			$subjectPlan = new SubjectPlan();
			$subjectPlan->setConnector($this->connector);
			$res = $this->connector->getObjectResult($auth);
			
			//Recupero la lista delle entries
			$sub_list = $subjectPlan->getList($res->id_piano, "anno");
			$plan = new Plan($res->id_piano, $res->codice, $res->id_corso, $sub_list);
			
			//Calcolo le informazioni di servizio
			$plan->course_name = $course->getById($plan->course_id)->name;
				
			//ritorno il piano cercato
			return $plan;
		}
		return false;
	}
	public function getList($order="id_piano")
	{
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		
		$sql="SELECT id_piano, codice, id_corso, c.nome as nome_corso, count(id_materia) as num_materie FROM piani natural join corsi c group by (id_piano) order by $order";
		$auth = $this->connector->query($sql);
		$lista_piani=array();
		
		if (mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{
				$plan = new Plan($res->id_piano,$res->codice, $res->id_corso);
				
				//Calcolo le informaizoni di servizio
				$plan->course_name = $res->nome_corso;
				$plan->num_materie = $res->num_materie;
				$lista_piani[] = $plan;
			}
		}
		
		return $lista_piani;		
	}
	public function getListByCourse($course_id)
	{
		$course_id = (int) $course_id;
		
		$sql="SELECT distinct id_piano FROM piani where id_corso='$course_id'";
		$auth = $this->connector->query($sql);
		$lista_piani=array();
		
		if (mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{
				$plan = $this->getById($res->id_piano);
				
				//Calcolo le informaizoni di servizio
				$plan->course_name = $res->nome_corso;
				$plan->num_materie = $res->num_materie;
				$lista_piani[] = $plan;
			}
		}
		
		return $lista_piani;	
	}
	public function storeFormValues($params)
	{			
		if (isset($params['savePlan']))
		{
			list($course_id, $subject_string) = explode("#",$params['savePlan'],2);
			$plan_code = trim(filter_var($params['codicePiano'], FILTER_SANITIZE_STRING));
			$plan_id = (int)$params['id_piano'];		//Questa variabile viene valorizzata solo in caso di modifica
			
			//formatto le materie
			if ($subject_string!="") $materie = explode(",",$subject_string);
			
			
			$lista_subjectPlan = array();
			for ($i=0;$i<count($materie);$i++)
			{
				list($nome_materia, $anno) = explode(":",trim($materie[$i]));
												
				//Informazioni di servizio
				$subject = new Subject();
				$subject->setConnector($this->connector);
				$id_materia = $subject->getByName($nome_materia)->id;
				
				$subjPlan = new SubjectPlan($id_materia, $nome_materia, $anno);
				$lista_subjectPlan[] = $subjPlan;
			}
			$this->__construct($plan_id, $plan_code, $course_id, $lista_subjectPlan);
		}
	}
	public function getAjaxList($id, $order="nome")
	{
		$lista = $this->getListByCourse($id);
		return $ret=json_encode($lista);
	}
	
}

class SubjectPlan
{
	public $subject_id;		//L'id della materia
	public $subject_name;	//Il nome della materia
	public $year;			//L'id del corso
	
	private $connector;		//Il database connector
		
	public function setConnector($conn)
	{
		$this->connector = $conn;
	}
	public function __construct($subject_id, $subject_name, $year)
	{
		$this->subject_id = $subject_id;
		$this->subject_name = $subject_name;
		$this->year = $year;
	}
	public function getList($id, $order="anno")
	{
		$id = (int) $id;
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		
		$sql="SELECT id_materia, nome, anno FROM piani p natural join materie where id_piano = '$id' ORDER BY $order;";
		$auth = $this->connector->query($sql);
		$list=array();
		if(mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{
				$sub=new SubjectPlan($res->id_materia, $res->nome, $res->anno);
				$list[] = $sub;
			}
		}
		return $list;
	}
}