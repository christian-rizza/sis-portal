<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<div id="users-contain" class="ui-widget">
	<div id="tableCourseContainer"></div>
	<script type="text/javascript">
	var tableCourse=new Table("tableCourse","tableCourseContainer");
	<?php
		$a = array("Codice","Nome Corso","Tipo","Anni","Modifica","Elimina");
		
		
		for ($i=0;$i<count($a);$i++)
			echo "tableCourse.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['courses'] as $corso)
		{
			echo "tableCourse.colonne[0].addVal(\"".$corso->id."\");";
			echo "tableCourse.colonne[1].addVal(\"".$corso->name."\");";
			echo "tableCourse.colonne[2].addVal(\"".$corso->type."\");";
			echo "tableCourse.colonne[3].addVal(\"".$corso->years."\");";
			echo "tableCourse.colonne[4].addVal(\"<center><button onclick='editFromView($corso->id);'>Modifica</button></center>\");";
			echo "tableCourse.colonne[5].addVal(\"<center><button onclick='deleteFromView($corso->id);'>Elimina</button></center>\");";
		}
		echo "tableCourse.drawTable(false);\n\n";
	?>
    </script>
</div>