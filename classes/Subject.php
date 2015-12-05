<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

@include_once "../classes/Mysql.php";

class Subject
{
	public $id;
	public $name;
	public $description;
	
	private $connector;
		
	public function __construct($id, $name, $description)
	{
		$this->id=$id;
		$this->name = $name;
		$this->description = $description;
	}
	public function setConnector($conn)
	{
		$this->connector = $conn;
	}
	public function insert()
	{
		if (!$this->name) return "Inserire il nome della materia";
		
		$tabella = "materie";
		$valori = array($this->name, $this->description);
		$campi = array("nome","descrizione");
		$auth = $this->connector->insert($tabella, $campi, $valori);
		
		if (mysql_errno()==1062) return "Materia presente in archivio";
		else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function delete($id)
	{		
		$id = (int) $id;
		$sql="DELETE FROM materie WHERE id_materia = $id;";
		$auth = $this->connector->query($sql);
		
		if (mysql_errno()==1451) return "Questa materia è associata ad un piano di studio attivo oppure ad un esame sostenuto ed è impossibile cancellarla";
		if (mysql_errno()>0) return "Errore interno numero ".mysql_errno();
	}
	public function update() 
	{
		if (!$this->id) return "Non è stato possibile trovare la materia, contattare il fornitore!";
		if (!$this->name) return "Inserire il nome della materia";
		
		$tabella = "materie";
		$campi=array("nome","descrizione");
		$valori = array($this->name, $this->description);
		$campi_com = array("id_materia");
		$valori_com = array($this->id);
	    $auth = $this->connector->update($tabella, $campi, $valori, $campi_com, $valori_com);
		
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();		
	}
	public function getList($order="nome") 
	{
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		
		// interrogazione della tabella
		$sql="SELECT * FROM materie ORDER BY $order";
		$auth = $this->connector->query($sql);
		
		$list=array();
		// controllo sul risultato dell'interrogazione
		if(mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$sub = new Subject($res->id_materia, $res->nome, $res->descrizione);
				$list[] = $sub;
			}
		}
		return $list;
	}
	public function getById($id) 
	{
		$id = (int) $id;
		
		// interrogazione della tabella
		$sql="SELECT * FROM materie WHERE id_materia ='$id'";
		
		$auth = $this->connector->query($sql);
		if(mysql_num_rows($auth)>0)
		{
			// chiamata alla funzione per l'estrazione dei dati
			$res = $this->connector->getObjectResult($auth);
			$sub = new Subject($res->id_materia, $res->nome, $res->descrizione);
			return $sub;
		}
	}
	public function storeFormValues($data)
	{
		if ( isset( $data['id_materia'] ) && $data['id_materia']!="") $id = (int) $data['id_materia'];
		if ( isset( $data['nome'] ) && $data['nome']!="") $name = trim(filter_var($data['nome'],FILTER_SANITIZE_STRING));
		if ( isset( $data['descrizione'])) $description = trim(filter_var($data['descrizione'],FILTER_SANITIZE_STRING));
		
		$this->__construct($id, $name, $description);
	}
	public function search($val, $order="nome") 
	{	
		if ( isset($val) && $val!="") $val=trim(filter_var($val,FILTER_SANITIZE_STRING));
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		
		if ($val) 
		{			
			// interrogazione della tabella
			$sql="SELECT * FROM materie WHERE nome like '%$val%' ORDER BY $order";	
			$auth = $this->connector->query($sql);
			
			$list=array();
			// controllo sul risultato dell'interrogazione
			if(mysql_num_rows($auth)>0)
			{
				while ($res = $this->connector->getObjectResult($auth))
				{				
					$sub = new Subject($res->id_materia, $res->nome, $res->descrizione);
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
	public function getByName($name)
	{
		$name = trim(filter_var($name,FILTER_SANITIZE_STRING));
		
		// interrogazione della tabella
		$sql="SELECT * FROM materie WHERE nome ='$name'";
		$auth = $this->connector->query($sql);
		if(mysql_num_rows($auth)>0)
		{
			// chiamata alla funzione per l'estrazione dei dati
			$res =  $this->connector->getObjectResult($auth);
			$sub = new Subject($res->id_materia, $res->nome, $res->descrizione);
			return $sub;
		}
	}
}
	