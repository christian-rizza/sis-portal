<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

@include_once "../classes/PasswordGenerator.php";

class Student
{
	private $connector;
	
	//Generale
	public $id;
	public $id_plan;
	public $year;
	public $first_year;
	public $foto;
	public $name;
	public $surname;
	public $sex;
	public $prov_born;
	public $city_born;
	public $date_born;
	public $cf;
	
	//Residenza
	public $address;
	public $city_res;
	public $prov_res;
	public $cap;
	public $tel;
	public $email;
	public $cell_personal;
	public $cell_parent;
	
	//Istruzione
	public $nome_titolo;
	public $data_titolo;
	public $nome_istituto;
	public $citta_istituto;
	public $experience;
	public $languages;
	public $computer;
	
	//Informazioni di servizio
	public $course_name;
	public $course_year;
	public $course_id;
	
	public function setConnector($conn)
	{
		$this->connector = $conn;
	}
	public function __construct($data=array()) 
	{
		
		if ( isset( $data['id_studente'] ) && $data['id_studente']!="") $this->id = (int) $data['id_studente'];
		if ( isset( $data['id_piano'] ) && $data['id_piano']!="") $this->id_plan = (int) $data['id_piano'];
		if ( isset( $data['anno_iscrizione'] ) && $data['anno_iscrizione']!="") $this->year = (int) $data['anno_iscrizione'];
		if ( isset( $data['prima_iscrizione'] ) && $data['prima_iscrizione']!="") $this->first_year = (int) $data['prima_iscrizione'];
		
		//Generale
		if ( isset( $data['foto'] ) && $data['foto']!="") $this->foto = trim(filter_var($data['foto'], FILTER_SANITIZE_STRING));
		if ( isset( $data['nome'] ) && $data['nome']!="") $this->name = trim(filter_var($data['nome'],FILTER_SANITIZE_STRING));
		if ( isset( $data['cognome'] ) && $data['cognome']!="") $this->surname = trim(filter_var($data['cognome'],FILTER_SANITIZE_STRING));
		if ( isset( $data['sesso'] ) && $data['sesso']!="") $this->sex = trim(filter_var($data['sesso'],FILTER_SANITIZE_STRING));
		if ( isset( $data['prov_nascita'] ) && $data['prov_nascita']!="") $this->prov_born = trim(filter_var($data['prov_nascita'],FILTER_SANITIZE_STRING));
		if ( isset( $data['luogo_nascita'] ) && $data['luogo_nascita']!="") $this->city_born = trim(filter_var($data['luogo_nascita'],FILTER_SANITIZE_STRING));
		if ( isset( $data['data_nascita'] ) && $data['data_nascita']!="") $this->date_born = trim(filter_var($data['data_nascita'],FILTER_SANITIZE_STRING));
		if ( isset( $data['cf'] ) && $data['cf']!="") $this->cf = trim(filter_var($data['cf'],FILTER_SANITIZE_STRING));
		
		//Residenza
		if ( isset( $data['indirizzo'] ) && $data['indirizzo']!="") $this->address = trim(filter_var($data['indirizzo'],FILTER_SANITIZE_STRING));
		if ( isset( $data['citta_residenza'] ) && $data['citta_residenza']!="") $this->city_res = trim(filter_var($data['citta_residenza'],FILTER_SANITIZE_STRING));
		if ( isset( $data['prov_residenza'] ) && $data['prov_residenza']!="") $this->prov_res = trim(filter_var($data['prov_residenza'],FILTER_SANITIZE_STRING));
		if ( isset( $data['cap'] ) && is_numeric($data['cap'])) $this->cap = $data['cap'];
		if ( isset( $data['tel'] ) && is_numeric($data['tel'])) $this->tel = $data['tel'];
		if ( isset( $data['email'] ) && @eregi("^[a-z0-9][_.a-z0-9-]+@([a-z0-9][0-9a-z-]+.)+([a-z]{2,4})" , trim($data['email']))) $this->email = strtolower($data['email']);
		if ( isset( $data['cell_personale'] ) && is_numeric($data['cell_personale'])) $this->cell_personal = $data['cell_personale'];
		if ( isset( $data['cell_genitore'] ) && is_numeric($data['cell_genitore'])) $this->cell_parent = $data['cell_genitore'];
		
		//Istruzione
		if ( isset( $data['nome_titolo'] ) && $data['nome_titolo']!="") $this->nome_titolo = trim(filter_var($data['nome_titolo'],FILTER_SANITIZE_STRING));
		if ( isset( $data['data_titolo'] ) && $data['data_titolo']!="") $this->data_titolo = trim(filter_var($data['data_titolo'],FILTER_SANITIZE_STRING));
		if ( isset( $data['nome_istituto'] ) && $data['nome_istituto']!="") $this->nome_istituto = trim(filter_var($data['nome_istituto'],FILTER_SANITIZE_STRING));
		if ( isset( $data['citta_istituto'] ) && $data['citta_istituto']!="") $this->citta_istituto = trim(filter_var($data['citta_istituto'],FILTER_SANITIZE_STRING));
		if ( isset( $data['esperienze'] ) && $data['esperienze']!="") $this->experience = trim(filter_var($data['esperienze'],FILTER_SANITIZE_STRING));
		if ( isset( $data['lingue'] ) && $data['lingue']!="") $this->languages = trim(filter_var($data['lingue'],FILTER_SANITIZE_STRING));
		if ( isset( $data['informatica'] ) && $data['informatica']!="") $this->computer = trim(filter_var($data['informatica'],FILTER_SANITIZE_STRING));		
	}
	
	public function storeFormValues($params)
	{
		$this->__construct( $params );
	}
	public function validate()
	{
		
		//Generale
		if (!$this->name) return "Inserire il nome";
		if (!$this->surname) return "Inserire il cognome";
		if (!$this->sex) return "Inserire il sesso";
		if (!$this->prov_born) return "Inserire la provincia di nascita";
		if (!$this->city_born) return "Inserire il luogo di nascita";
		if (!$this->date_born) return "Data di nascita non valida. Utilizzare il formato (gg/mm/aaaa)";
		if (!$this->cf) return "Inserire il codice fiscale";
		
		//Residenza
		if (!$this->address) return "Inserire l'indirizzo di residenza";
		if (!$this->city_res) return "Inserire il comune di residenza";
		if (!$this->prov_res) return "Selezionare la provincia di residenza";
		if (!$this->cap) return "Inserire il codice di avviamento postale (CAP)";
		if (!$this->email) return "Inserire un indirizzo di email valido";
		if (!$this->tel && !$this->cell_personal && !$this->cell_parent) return "Inserire almeno un recapito telefonico";	
		
		//Istruzione
		if (!$this->nome_titolo) return "Inserire il titolo di studio";
		
		//Iscrizione
		if (!$this->first_year) return "Inserire l'anno di prima iscrizione";
		
	}
	public function insert()
	{
		
		//Dati obbligatori
		if ($validation = $this->validate()) return $validation;
		
		// Inserimento dati
		$tabella = "studenti";
		$valori = array(
			$this->foto,
			$this->name,
			$this->surname, 
			$this->sex, 
			$this->prov_born, 
			$this->city_born, 
			$this->date_born, 
			$this->cf,
			$this->address,
			$this->city_res, 
			$this->prov_res, 
			$this->cap,
			$this->tel, 
			$this->cell_personal, 
			$this->cell_parent,
			$this->email,
			$this->nome_titolo,
			$this->data_titolo,
			$this->nome_istituto,
			$this->citta_istituto,
			$this->experience,
			$this->languages,
			$this->computer,
			$this->id_plan,
			$this->year,
			$this->first_year);
			
		$campi =  array("foto","nome","cognome","sesso","prov_nascita","luogo_nascita","data_nascita","cf","indirizzo","citta_residenza",
							"prov_residenza","cap","tel","cell_personale","cell_genitore","email","nome_titolo","data_titolo","nome_istituto",
							"citta_istituto","esperienze","lingue","informatica","id_piano","anno_iscrizione","prima_iscrizione");
							
		$auth = $this->connector->insert($tabella, $campi, $valori);
		if (mysql_errno()==1062) return "Studente presente in archivio";
		else if (mysql_errno()>0) return "Errore interno numero: ".mysql_error();
	}
	public function delete($id) 
	{
		// interrogazione della tabella
		$sql="DELETE FROM studenti WHERE id_studente = $id";
		$auth = $this->connector->query($sql);
		if (mysql_errno()==1451) return "Lo studente possiede una carriera accademica oppure dei pagamenti effettuati e non è possibile eliminarlo";
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno();
	}
	public function getList($order="id_studente", $numRows = 1000000) 
	{
		
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		$numRows = (int) $numRows;
		
		$sql="SELECT * FROM studenti ORDER BY ".mysql_escape_string($order)." LIMIT $numRows";
		$auth = $this->connector->query($sql);
		
		$list=array();

		if(mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$student = new Student();
				$student->id=$res->id_studente;
				$student->name=$res->nome;
				$student->surname=$res->cognome;
				$student->date_born=$res->data_nascita;
				$student->id_plan=$res->id_piano;
				$student->email = $res->email;
				$student->cf = $res->cf;
				
				$plan = new Plan();
				$plan->setConnector($this->connector);
				$student_plan = $plan->getById($student->id_plan);
				$student->course_name = $student_plan->course_name;				
				$list[] = $student;
			}
		}
		return $list;
	}
	public function getById($id) 
	{
		
		// interrogazione della tabella
		$sql="SELECT * FROM studenti WHERE id_studente='$id'";
		$auth = $this->connector->query($sql);
		$student=null;
		
		if(mysql_num_rows($auth)>0)
		{
			$res =  $this->connector->getObjectResult($auth);
			$student = new Student(get_object_vars($res));
		}
		
		//Gestisco i dati di servizio
		$plan=new Plan();
		$plan->setConnector($this->connector);
		$student_plan=$plan->getById($student->id_plan);
		$student->course_id = $student_plan->course_id;
		
		$course = new Course();
		$course->setConnector($this->connector);
		$student_course = $course->getById($student->course_id);
		$student->course_name = $student_course->name;
		$student->course_year = $student_course->years;
		
		return $student;
	}
	public function update()
	{
		if (!$this->id) return "Non è stato possibile trovare l'id dello studente, contattare il fornitore!";
		//Dati obbligatori
		if ($validation = $this->validate()) return $validation;
		
		// Inserimento dati
		$tabella = "studenti";
		$valori = array(
			$this->foto,
			$this->name,
			$this->surname, 
			$this->sex, 
			$this->prov_born, 
			$this->city_born, 
			$this->date_born, 
			$this->cf,
			$this->address,
			$this->city_res, 
			$this->prov_res, 
			$this->cap,
			$this->tel, 
			$this->cell_personal, 
			$this->cell_parent,
			$this->email,
			$this->nome_titolo,
			$this->data_titolo,
			$this->nome_istituto,
			$this->citta_istituto,
			$this->experience,
			$this->languages,
			$this->computer,
			$this->id_plan,
			$this->year,
			$this->first_year);
			
		$campi = array("foto","nome","cognome","sesso","prov_nascita","luogo_nascita","data_nascita","cf","indirizzo",
						"citta_residenza","prov_residenza","cap","tel","cell_personale","cell_genitore","email",
						"nome_titolo","data_titolo","nome_istituto","citta_istituto","esperienze","lingue","informatica",
						"id_piano","anno_iscrizione","prima_iscrizione");
		$auth = $this->connector->update($tabella, $campi, $valori,array("id_studente"),array($this->id));
		
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno()." ".mysql_error();
		
	}
	public function search($val,$order="nome", $numRows = 1000000)
	{
		$order = trim(filter_var($order, FILTER_SANITIZE_STRING));
		$numRows = (int) $numRows;
		
		// interrogazione della tabella
		$sql="SELECT id_studente,nome,cognome,data_nascita,id_piano FROM studenti WHERE nome LIKE '%$val%' OR cognome LIKE '%$val%' ORDER BY $order LIMIT $numRows";
		$auth = $this->connector->query($sql);
		
		$list=array();

		if(mysql_num_rows($auth)>0)
		{
			while ($res = $this->connector->getObjectResult($auth))
			{				
				$student = new Student();
				$student->id=$res->id_studente;
				$student->name=$res->nome;
				$student->surname=$res->cognome;
				$student->date_born=$res->data_nascita;
				$student->id_plan=$res->id_piano;
				
				$plan = new Plan();
				$plan->setConnector($this->connector);
				$student_plan = $plan->getById($student->id_plan);
				$student->course_name = $student_plan->course_name;				
				$list[] = $student;
			}
		}
		return $list;
	}
	public function generatePassword($password='')
	{
		if (!$this->id) return "Non è stato possibile trovare l'id dello studente, contattare il fornitore!";
		$tabella = "password";
		
		//Controllo se esiste già una password per l'utente
		$sql = "SELECT * FROM $tabella WHERE id_studente ='$this->id'";
		$auth = $this->connector->query($sql);
		
		
		if(mysql_num_rows($auth)>0)
		{
			$res =  $this->connector->getObjectResult($auth);
		}
		
		$pwdGen = new PasswordGenerator();
		
		
		if($password=="")
		{
			$password = $pwdGen->createPassword();
		}
		else
		{
			$pwd = trim(filter_var($password,FILTER_SANITIZE_STRING));
		}
	
		if ($res)
		{
			$valori = array(sha1($password));
			$campi = array("password");
			$campi_com = array("id_studente");
			$valori_com = array($this->id);
			$auth = $this->connector->update($tabella, $campi, $valori, $campi_com, $valori_com);
			if (!$pwdGen->sendPassword($password, $this)) return "Errore durante l'invio della password";
		}
		else
		{
			$valori = array($this->id, sha1($password));
			$campi = array("id_studente", "password");
			$auth = $this->connector->insert($tabella, $campi, $valori);
		}
		if (mysql_errno()>0) return "Errore interno numero: ".mysql_errno()." ".mysql_error();
	}
}