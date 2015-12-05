<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
@include_once "../classes/PaymentEntry.php";

class Payment
{
	public $student_id;			//id dello studente
	public $payment_list;
	
	//Informazioni di servizio
	public $student_name;
	public $student_surname;
	public $student_borndate;
	public $payment_total;
	private $connector;			//L'oggetto MySQLConnector
	
	public function __construct($student_id, $payment_list=array())
	{
		$this->student_id = (int) $student_id;
		$this->payment_list = $payment_list;
	}
	public function setConnector($conn)
	{
		$this->connector = $conn;
	}
	public function insert()
	{		
		if (!$this->student_id) return "Selezionare lo studente";
		if (count($this->payment_list)<=0) return "Inserire almeno un pagamento";
		
		$tabella = "pagamenti";
		
		for ($i=0;$i<count($this->payment_list);$i++)
		{		
			{		
				$valori = array($this->student_id, $this->payment_list[$i]->value, $this->payment_list[$i]->date, $this->payment_list[$i]->causal);
				$campi = array("id_studente", "importo", "data","causale");
				$auth = $this->connector->insert($tabella, $campi, $valori);
				
				if (mysql_errno()==1062) return "Una delle materie è gia presente nel piano scelto. Sono state inserite solo le materie valide!";
				else if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
			}
		}
	}
	public function delete($id)
	{		
		// interrogazione della tabella
		$id = (int)$id;
		
		$sql="DELETE FROM pagamenti WHERE id_studente = '$id';";
		$auth = $this->connector->query($sql);
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function update()
	{
		if ($this->student_id)
		{
			mysql_query("BEGIN"); 
			
			$this->delete($this->student_id);
			$ret = $this->insert();
			
			if ($ret)
			{
				mysql_query("ROLLBACK");
				return "Errore durante l'aggiornamento, l'inserimento è stato annullato<br>".$ret;
			}
			else
			{
				mysql_query("COMMIT");
			}
		}
	}
	public function getById($id)
	{
		$id=(int) $id;
		$sql="SELECT * FROM pagamenti WHERE id_studente='$id'";
		$auth = $this->connector->query($sql);
		
		if(mysql_num_rows($auth)>0)
		{
			$payment_list = array();			
			while ($res=$this->connector->getObjectResult($auth))
			{
				
				$entry = new PaymentEntry($res->importo, $res->data, $res->causale);
				$payment_list[] = $entry;
			}
			$payment = new Payment($id,$payment_list);
			
			//ritorno il piano cercato
			return $payment;
		}
		return false;
	}
	public function getList($order="cognome")
	{
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		
		$sql="SELECT id_studente,nome,cognome,data_nascita, SUM(importo) as totale FROM pagamenti p natural join studenti group by(id_studente) order by $order";
		$auth = $this->connector->query($sql);
		$payment_list=array();
		
		if (mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{
				$payment = new Payment($res->id_studente);
				
				//Calcolo le informaizoni di servizio
				$payment->student_name=$res->nome;
				$payment->student_surname = $res->cognome;
				$payment->student_borndate = $res->data_nascita;
				$payment->payment_total = $res->totale;
				
				$payment_list[] = $payment;
			}
		}
		
		return $payment_list;		
	}
	public function storeFormValues($params)
	{	
		if (isset($params['savePayment']))
		{
			list($student_id, $payment_string) = explode("#",$params['savePayment']);
			
			$payment_string = trim(filter_var($payment_string, FILTER_SANITIZE_STRING));
			
			//formatto le materie
			if ($payment_string!="") $payments = explode(",",$payment_string);
			$payment_list = array();
			for ($i=0;$i<count($payments);$i++)
			{
				list($value, $date, $causal) = explode(":",trim($payments[$i]));
				$entry = new PaymentEntry($value, $date, $causal);
				$payment_list[] = $entry;
			}
			
			$this->__construct($student_id, $payment_list);
		}
	}
	
}