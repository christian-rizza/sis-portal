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
		
		$a = array("Codice Ins.","Insegnamento", "Anno Corso","Data","Esito","Modifica","Elimina");
		
		
		for ($i=0;$i<count($a);$i++)
			echo "tableCourse.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['edit']->exam as $exam)
		{
			$vote="";
			switch ($exam->vote)
			{
				case 31:
					$vote="30 e Lode";
					break;
				case 32:
					$vote="APPROVATO";
					break;
				case 4:
					$vote="INSUFFICIENTE";
					break;
				case 6:
					$vote="SUFFICIENTE";
					break;
				case 7:
					$vote="DISCRETO";
					break;
				case 8:
					$vote="BUONO";
					break;
				case 9:
					$vote="OTTIMO";
					break;
				case 10:
					$vote="ECCELLENTE";
					break;
				default:
					$vote=$exam->vote;
				
			}
			if ($exam->year=="") $exam->year="*";
			echo "tableCourse.colonne[0].addVal(\"".$exam->id_subject."\");";
			echo "tableCourse.colonne[1].addVal(\"".$exam->subject_name."\");";
			echo "tableCourse.colonne[2].addVal(\"".$exam->year."\");";
			echo "tableCourse.colonne[3].addVal(\"".$exam->date."\");";
			echo "tableCourse.colonne[4].addVal(\"".$vote."\");";
			echo "tableCourse.colonne[5].addVal(\"<center><button onclick='editFromView($exam->id_subject);'>Modifica</button></center>\");";
			echo "tableCourse.colonne[6].addVal(\"<center><button onclick='deleteFromView($exam->id_subject);'>Elimina</button></center>\");";
		}
		echo "tableCourse.drawTable(false);\n\n";
	?>
    </script>
    <form id="formModuleView" action="index.php?module=exam" method="POST">
        <input type="hidden" id="operation" name="operation" /> 
        <input type="hidden" id="id_studente" name="id_studente" value="<?php echo $result['edit']->student->id ?>" />
    </form>
    <?php
		if ($exam->year=="*") echo "<p>* L'esame deve essere convalidato d'ufficio poiché il piano di studio dello studente non lo prevede </p>";
	?>
</div>