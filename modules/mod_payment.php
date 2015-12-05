<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<div id="users-contain" class="ui-widget">
	<div id="tablePlanContainer"></div>
	<script type="text/javascript">
	var planTable=new Table("tablePlan","tablePlanContainer");
	<?php
		$a = array("Matricola","Cognome","Nome","Data di nascita","Totale Ricevuto","Modifica","Elimina");
		
		for ($i=0;$i<count($a);$i++)
			echo "\nplanTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['payments'] as $payment)
		{
			echo "\nplanTable.colonne[0].addVal(\"".$payment->student_id."\");";
			echo "\nplanTable.colonne[1].addVal(\"".$payment->student_surname."\");";
			echo "\nplanTable.colonne[2].addVal(\"".$payment->student_name."\");";
			echo "\nplanTable.colonne[3].addVal(\"".$payment->student_borndate."\");";
			echo "\nplanTable.colonne[4].addVal(\"".$payment->payment_total." €\");";
			echo "\nplanTable.colonne[5].addVal(\"<center><button onclick='editFromView($payment->student_id);'>Modifica</button></center>\")";
			echo "\nplanTable.colonne[6].addVal(\"<center><button onclick='deleteFromView($payment->student_id);'>Elimina</button></center>\")";
		}
		echo "\nplanTable.drawTable(false);\n\n";
	?>
    </script>
</div>