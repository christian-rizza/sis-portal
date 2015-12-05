<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

@include_once "../classes/Course.php";

class PaymentEntry
{
	public $value;			
	public $date;			
	public $causal;
	
	private $connector;		//Il database connector
		
	public function setConnector($conn)
	{
		$this->connector = $conn;
	}
	
	public function __construct($value, $date, $causal)
	{
		$this->value = $value;
		$this->date = $date;
		$this->causal = $causal;
	}
}