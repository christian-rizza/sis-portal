<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
 
class Notice
{
	public $id;
	public $title;
	public $text;
	public $id_dest;
	public $mail_send;
	
	//Informazioni di servizio
	private $connector;
	
	public function __construct($id, $title, $text, $id_dest, $mail_send)
	{
		$this->id=$id;
		$this->title=$title;
		$this->text = $text;
		$this->id_dest = $id_dest;
		$this->mail_send = $mail_send;
	}
	public function setConnector($connector)
	{
		$this->connector = $connector;
	}
	public function insert()
	{
		if (!$this->title) return "Inserire il titolo dell'avviso";
		if (!$this->text) return "Inserire il testo dell'avviso"; 
		if (!is_array($this->id_dest)) return "Selezionare almeno un destinatario";
		
		$tabella = "avvisi";
		$campi = array("titolo","testo","id_studente","invio_mail");
		$valori = array($this->title, $this->text, implode(";", $this->id_dest), $this->mail_send);
	
		$auth = $this->connector->insert($tabella, $campi, $valori);
		if (mysql_errno()==1062) return "Avviso già presente";
		else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
		
		if ($this->mail_send)
		{
			$student = new Student();
			$student->setConnector($this->connector);
			
			$lista = array();
			if (in_array(0, $this->id_dest))
			{
				$lista = $student->getList();				
			}
			else
			{
				foreach ($this->id_dest as $id_dest)
				{
					$tmp_stud = $student->getById($id_dest);
					$lista[] = $tmp_stud;
				}
			}

			$errore = "";
			foreach ($lista as $student)
			{
				//if ($student->email=="sbrandollo@gmail.com")
				{
					$student->setConnector($this->connector);
					
					$destinatario=$student->email;
					$mittente_mail="";
					$oggetto="";
					$messaggio="";
					$intestazioni = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: $mittente_mail";
 
					//invio la mail
					$risultato = mail($destinatario, $oggetto, $messaggio, $intestazioni);
					//reindirizzamento
					if (!$risultato) $errore .= "Problema nell'inoltro dell'email all'indirizzo $destinatario. L'avviso è stato comunque registrato sul portale<br>";
				}
			}
			if ($errore!="") return $errore;
		}
	}
	public function delete($id)
	{
		//Controllo l'id
		$id = (int)$id;		
		$sql = "DELETE FROM avvisi WHERE id_avviso = $id";
		$auth = $this->connector->query($sql);
		
		if (mysql_errno()==1451) return "Questo avviso  è attivo ed è impossibile eliminarlo. ";
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function getList($order="titolo")
	{
		$order = trim(filter_var($order,FILTER_SANITIZE_STRING));
		
		//interrogazione tabella
		$sql="SELECT * FROM avvisi ORDER BY $order";
		$auth = $this->connector->query($sql);
		
		$list=array();
		
		// controllo sul risultato dell'interrogazione
		if(mysql_num_rows($auth)>0)
		{
			$notice = new Notice();
			$notice->setConnector($this->connector);
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$notice = new Notice($res->id_avviso, $res->titolo, $res->testo, $res->id_studente, $res->invio_mail);
				
				$list[] = $notice;
			}
		}
		return $list;
	}
	public function storeFormValues($data)
	{
		if ( isset( $data['id_avviso'] ) && $data['id_avviso']!="") $id = (int) $data['id_avviso'];
		if ( isset( $data['titolo'] ) && $data['titolo']!="") $title = trim(filter_var($data['titolo'], FILTER_SANITIZE_STRING));
		if ( isset( $data['testo'] ) && $data['testo']!="") $text = trim(filter_var($data['testo'], FILTER_SANITIZE_SPECIAL_CHARS));
		if ( isset( $data['destinatario'] ) && is_array($data['destinatario'])) 
			$id_dest = $data['destinatario'];
		if ( isset( $data['invio_mail'] ) && $data['invio_mail']!="") $mail_send = (bool) $data['invio_mail'];
		
		$this->__construct($id, $title, $text, $id_dest, $mail_send);
	}
}

?>