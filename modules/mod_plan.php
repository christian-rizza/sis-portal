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
		$a = array("Codice","Corso","Num. materie","Modifica","Elimina");
		
		for ($i=0;$i<count($a);$i++)
			echo "\nplanTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['plans'] as $plan)
		{
			echo "\nplanTable.colonne[0].addVal(\"".$plan->plan_code."\");";
			echo "\nplanTable.colonne[1].addVal(\"".$plan->course_name."\");";
			echo "\nplanTable.colonne[2].addVal(\"".$plan->num_materie."\");";
			echo "\nplanTable.colonne[3].addVal(\"<center><button onclick='editFromView($plan->id);'>Modifica</button></center>\")";
			echo "\nplanTable.colonne[4].addVal(\"<center><button onclick='deleteFromView($plan->id);'>Elimina</button></center>\")";
		}
		echo "\nplanTable.drawTable(false);\n\n";
	?>
    </script>
</div>