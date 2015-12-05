<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

class MysqlConnector
{         
	private $link;
	private $active = false;	//Variabile per vedere se esiste giÃ  una connessione
	public $debug = true;		//Variabile per indicare se sono in modalitÃ  di debug
	private $debug_msg = array();	//Variabile che conterra i messaggi di debug da stampare
 
	/*
	 * Connessione alla base di dati
	 */
	public function connect() 
	{
		if(!$this->active)
		{
			if ($this->link= mysql_connect(DB_HOST,DB_USER,DB_PASS) or die (mysql_error()))
			{
				if ($this->debug) $this->debug_msg[]="Connessione";
				
				$selezione = mysql_select_db(DB_NAME,$this->link) or die (mysql_error());
				mysql_set_charset('utf8',$this->link); 
				$this->active = true;
			}
		}
		else
		{
			return true;
		}
	}
	
	/*
	 *	Disconnessione della base di dati
	 */
	public function disconnect()
	{
		if($this->active)
        {
			if(mysql_close($this->link))
			{
				if ($this->debug) $this->debug_msg[] = "Disconnessione" ;
				$this->active = false; 
				return true; 
			}
			else
			{
				return false; 
			}
		}
	}
	/*
	 * HTML dai messaggi di debug
	 * return string
	 */
	public function debugToHTML()
	{		
		$html="";
		foreach ($this->debug_msg as $msg)
		{
			$html.="[MysqlConnector] - ".$msg."<br>";
		}
		return $html;
	}
	/*
	 * Effettua una query sul database
	 * return il riferimento per recuperare la query
	 */
	public function query($sql) 
	{
		if(isset($this->active))
		{
			$res = mysql_query($sql);
			if ($this->debug && !$res) $this->debug_msg[] = "<strong>".mysql_error()."</strong> : ".$sql;
			else if ($this->debug) $this->debug_msg[] = $sql;
			return $res;
		}
		else
		{
			return false; 
		}
	}
	/*
	 * Formatta il risultato di una query sottoforma di oggetto
	 * return Oggetto contenente i dati
	 */
	public function getObjectResult($result)
	{
		if(isset($this->active))
		{
			$r = mysql_fetch_object($result);
			return $r;
		}
		else
		{
			return false; 
		}
	}
	/*
	 * Effettua un inserimento all'interno di una tabella
	 *
	 * table - Tabella dove inserire i dati
	 * field - lista dei campi della tabella
	 * value - valori da inserire nei rispettivi campi
	 *
	 */
	public function insert($table, $field, $value)
	{
		if (isset($this->active))
		{
			if (count($field)!=count($value))
			{
				if ($this->debug) $this->debug_msg[]= "Il numero dei valori e dei campi non coincidono";
				return false;
			}
			else
			{
				$f = implode(",",$field);
				$v = implode("','",$value);
				
				$sql = "INSERT INTO ".$table;
				$sql.= "(".$f.")";
				$sql.= " VALUES ('".$v."');";
				
				$res = $this->query($sql);
				return mysql_insert_id($this->link);
			}
		}
		else
		{
			return false;
		}
	}
	/*
	 * Effettua l'aggiornamento di uno o piÃ¹ dati
	 * table - Tabella dove inserire i dati
	 * field - lista dei campi della tabella
	 * value - valori da inserire nei rispettivi campi
	 * field_com - lista dei campi di comparazione per la clausula WHERE
	 * value_com - valori da comparare
	 */
	public function update($table, $field, $value, $field_com, $value_com)
	{
		if (isset($this->active))
		{
			if (count($field)!=count($value))
			{
				if ($this->debug) $this->debug_msg[]= "Il numero dei valori e dei campi non coincidono";
				return false;
			}
			else if (count($field_com)!=count($value_com) || count($field_com)==0)
			{
				if (count($field_com)==0)
				{
					if ($this->debug) $this->debug_msg[]= "Inserire almeno un campo di comparazione";
				}
				else
				{
					if ($this->debug) $this->debug_msg[]= "Il numero dei valori e dei campi di comparazione devono conincidere";
				}
				return false;
			}
			else
			{				
				//Istruzione principale
				$sql = "UPDATE ".$table." SET ";
				for ($i=0;$i<count($field);$i++)
				{
					$sql.= $field[$i]."='".$value[$i]."',";
				}
				$sql = substr($sql,0,strlen($sql)-1);
				
				//Condizioni
				$sql.= " WHERE ";
				for ($i=0;$i<count($field_com);$i++)
				{
					$sql.= $field_com[$i]."='".$value_com[$i]."' AND ";
				}
				$sql=substr($sql, 0, strlen($sql)-5);
				
				//Effettuo la query
				return $this->query($sql);
			}
		}
		else
		{
			return false;
		}
	}
}
?>