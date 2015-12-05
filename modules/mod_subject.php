<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<div id="users-contain" class="ui-widget">
	<div id="tableSubjectContainer"></div>
	<script type="text/javascript">
	var tableSubject=new Table("tabletableSubject","tableSubjectContainer");
	<?php
		
		$a = array("Codice","Materia", "Modifica","Elimina");
		
		
		for ($i=0;$i<count($a);$i++)
			echo "tableSubject.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['subjects'] as $sub)
		{
			echo "tableSubject.colonne[0].addVal(\"".$sub->id."\");";
			echo "tableSubject.colonne[1].addVal(\"".$sub->name."\");";
			echo "tableSubject.colonne[2].addVal(\"<center><button onclick='editFromView($sub->id);'>Modifica</button></center>\");";
			echo "tableSubject.colonne[3].addVal(\"<center><button onclick='deleteFromView($sub->id);'>Elimina</button></center>\");";

		}
		echo "tableSubject.drawTable();\n\n";
	?>
    </script>
</div>