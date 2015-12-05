<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
 
class Document
{
	public $id;
	public $path;
	public $type;		//Indica il corso!!!
	public $title;
	
	private $connector;
	
	//Informazioni di servizio
	public $course_name;
	
	public function __construct($id, $path, $type, $title)
	{
		$this->id=$id;
		$this->path=$path;
		$this->type = $type;
		$this->title = $title;
	}
	public function setConnector($connector)
	{
		$this->connector = $connector;
	}
	public function insert()
	{
		if (!file_exists($this->path)) return "Il file non è stato caricato correttamente";
		if (!$this->title) 
		{
			unlink($this->path);
			return "Inserire la didascalia"; 
		}
				
		$tabella = "upload";
		$campi = array("path","tipo","didascalia");
		$valori = array($this->path, $this->type, $this->title);
	
		$auth = $this->connector->insert($tabella, $campi, $valori);
		if (mysql_errno()==1062) return "Avviso già presente";
		else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function delete($id)
	{
		//Controllo l'id
		$id = (int)$id;
		
		//recupero il path da eliminare
		$sql = "SELECT * FROM upload WHERE id='$id';";
		$auth = $this->connector->query($sql);
		
		if ($res = $this->connector->getObjectResult($auth))
		{
			$path = $res->path;
			if (!unlink($path))
				return "Impossibile eliminare il file";
		}
		
		$sql = "DELETE FROM upload WHERE id= $id";
		$auth = $this->connector->query($sql);
		
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function getList($order="didascalia")
	{
		$order = trim(filter_var($order,FILTER_SANITIZE_STRING));
		
		//interrogazione tabella
		$sql="SELECT * FROM upload ORDER BY $order";
		$auth = $this->connector->query($sql);
		
		$list=array();
		
		// controllo sul risultato dell'interrogazione
		if(mysql_num_rows($auth)>0)
		{
			$doc = new Document();
			$doc->setConnector($this->connector);
			$course = new Course();
			$course->setConnector($this->connector);
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$doc = new Document($res->id, $res->path, $res->tipo, $res->didascalia);
				
				//Calcolo le informazioni di servizio
				if ($res->tipo==1)
				{
					$doc->course_name = "TUTTI";
				}
				else
				{
					$doc->course_name = $course->getById($res->tipo)->name;
				}
				
				$list[] = $doc;
			}
		}
		return $list;
	}
	public function storeFormValues($data, $path)
	{
		if ( isset( $data['id'] ) && $data['id']!="") $id = (int) $data['id'];
		if ( isset( $data['titolo'] ) && $data['titolo']!="") $title = trim(filter_var($data['titolo'], FILTER_SANITIZE_STRING));
		if ( isset( $data['course'] ) && $data['course']!="") $type = (int) $data['course'];
		
		if(isset($_FILES['file']))
	    {
        	$file = $_FILES['file'];
			if($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name']))
        	{
				$file_path = $path."/".$file['name'];
				$temp_path = $file['tmp_name'];
				if (file_exists($file_path)) return "Esiste già un file con lo stesso nome";
				if (!move_uploaded_file($file['tmp_name'], $file_path))
				{
					return "Errore durante il caricamento del file";
				}
        	}
			else
			{
				return "Errore durante il caricamento del file";
			}
		}
		
		$this->__construct($id, $file_path, $type, $title);
	}
}

?>