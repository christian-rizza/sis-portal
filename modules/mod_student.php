<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<div id="users-contain" class="ui-widget">
	<div id="studentTableContainer"></div>
	<script type="text/javascript">
	var studentTable=new Table("studentTable","studentTableContainer");
	<?php
		$a = array("Matricola","Nome","Cognome","Data di nascita","Corso associato","Modifica","Elimina");
		
		for ($i=0;$i<count($a);$i++)
			echo "\nstudentTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['students'] as $student)
		{
			echo "\nstudentTable.colonne[0].addVal(\"".sprintf("%010d",$student->id)."\");";
			echo "\nstudentTable.colonne[1].addVal(\"".$student->name."\");";
			echo "\nstudentTable.colonne[2].addVal(\"".$student->surname."\");";
			echo "\nstudentTable.colonne[3].addVal(\"".$student->date_born."\");";
			if ($student->course_name) echo "\nstudentTable.colonne[4].addVal(\"".$student->course_name."\");";
			else echo "\nstudentTable.colonne[4].addVal(\"NESSUNO\");";
			echo "\nstudentTable.colonne[5].addVal(\"<center><button onclick='editFromView($student->id);'>Modifica</button></center>\")";
			echo "\nstudentTable.colonne[6].addVal(\"<center><button onclick='deleteFromView($student->id);'>Elimina</button></center>\")";
		}
		echo "\nstudentTable.drawTable(false);\n\n";
	?>
    </script>
    <form id="formModuleView" action="index.php?module=student" method="POST">
    	<input type="hidden" id="operation" name="operation" /> 
    </form>
</div>