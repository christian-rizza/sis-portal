<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
 
class Course
{
	public $id;
	public $name;
	public $type;
	public $years;
	
	//Informazioni di servizio
	private $tipologie = array("AC","BI","PE","AN");
	private $connector;
	
	public function __construct($id, $name, $type, $years)
	{
		$this->id=$id;
		$this->name=$name;
		$this->type=$type;
		$this->years=$years;
	}
	public function setConnector($connector)
	{
		$this->connector = $connector;
	}
	public function insert()
	{
		if (!$this->name) return "Inserire il nome del corso";
		if (!$this->type) return "Tipo corso non valido"; 
		if (!$this->years) return "Numero di anni non corretto";
		
		$tabella = "corsi";
		$campi = array("nome","tipo","anni");
		$valori = array($this->name,$this->type, $this->years);
	
		$auth = $this->connector->insert($tabella, $campi, $valori);
		if (mysql_errno()==1062) return "Corso presente in archivio ";
		else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function delete($id)
	{
		//Controllo l'id
		$id = (int)$id;		
		$sql = "DELETE FROM corsi WHERE id_corso = $id";
		$auth = $this->connector->query($sql);
		
		if (mysql_errno()==1451) return "Questo corso è associato ad un piano di studio attivo ed è impossibile eliminarlo. ";
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function update()
	{
		if (!$this->id) return "Non è stato possibile trovare il corso, contattare il fornitore!";
		if (!$this->name) return "Inserire il nome del corso";
		if (!$this->years) return "Numero di anni non corretto";
		if (!$this->type) return "Tipo corso non valido"; 
				
		$table = "corsi";
		$field = array("nome","tipo","anni");
		$value = array($this->name, $this->type, $this->years);
		$field_com = array("id_corso");
		$value_com = array($this->id);
		
		$auth = $this->connector->update($table, $field, $value, $field_com, $value_com);
		
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();		
	}
	public function getList($order="nome")
	{
		$order = trim(filter_var($order,FILTER_SANITIZE_STRING));
		
		//interrogazione tabella
		$sql="SELECT * FROM corsi ORDER BY $order";
		$auth = $this->connector->query($sql);
		
		$list=array();
		// controllo sul risultato dell'interrogazione
		if(mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$corso = new Course($res->id_corso, $res->nome, $res->tipo, $res->anni);
				$list[] = $corso;
			}
		}
		return $list;
	}
	public function getById($id)
	{
		$id = (int)$id;
		$sql="SELECT id_corso, nome, tipo, anni FROM corsi WHERE id_corso= $id";
		$auth = $this->connector->query($sql);
		if(mysql_num_rows($auth)>0)
		{
			// chiamata alla funzione per l'estrazione dei dati
			$res =  $this->connector->getObjectResult($auth);
			$corso = new Course($res->id_corso, $res->nome, $res->tipo, $res->anni);
			return $corso;
		}
		return false;
	}
	public function storeFormValues($data)
	{
		if ( isset( $data['id_corso'] ) && $data['id_corso']!="") $id = (int) $data['id_corso'];
		if ( isset( $data['nome'] ) && $data['nome']!="") $name = trim(filter_var($data['nome'],FILTER_SANITIZE_STRING));
		if ( isset( $data['tipo'] ) && $data['tipo']!="" && in_array($data['tipo'], $this->tipologie)) $type = trim(filter_var($data['tipo'],FILTER_SANITIZE_STRING));
		if ( isset( $data['anni'] ) && $data['anni']!="") $years = (int) $data['anni'];
		
		$this->__construct($id, $name, $type, $years);
	}
	public function search($val, $order="nome") 
	{	
		if ( isset($val) && $val!="") $val=trim(filter_var($val,FILTER_SANITIZE_STRING));
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		
		if ($val)
		{			
			// interrogazione della tabella
			$sql="SELECT * FROM corsi WHERE nome like '%$val%' ORDER BY $order";	
			$auth = $this->connector->query($sql);
			
			$list=array();
			// controllo sul risultato dell'interrogazione
			if(mysql_num_rows($auth)>0)
			{
				while ($res = $this->connector->getObjectResult($auth))
				{				
					$sub = new Course($res->id_corso, $res->nome, $res->tipo, $res->anni);
					$list[] = $sub;
				}
			}
			return $list;
		}
		else 
		{	
			return $this->getList($order);
		}
		
	}
}