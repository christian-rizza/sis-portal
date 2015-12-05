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
	var tableBooked=new Table("tableBooked","tableCourseContainer");
	<?php
		$a = array("Corso","Piano di studi","Materia","Docente","Data Esame","Elimina");
		
		
		for ($i=0;$i<count($a);$i++)
			echo "tableBooked.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['booked'] as $book)
		{
			echo "tableBooked.colonne[0].addVal(\"".$book->course_name."\");";
			echo "tableBooked.colonne[1].addVal(\"".$book->plan_code."\");";
			echo "tableBooked.colonne[2].addVal(\"".$book->subject_name."\");";
			echo "tableBooked.colonne[3].addVal(\"".$book->docente."\");";
			echo "tableBooked.colonne[4].addVal(\"".$book->exam_date."\");";
			echo "tableBooked.colonne[5].addVal(\"<center><button onclick='deleteFromView($book->id);'>Elimina</button></center>\");";
		}
		echo "tableBooked.drawTable(false);\n\n";
	?>
    </script>
</div>