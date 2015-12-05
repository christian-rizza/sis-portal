<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
	
?>
	
<div id="users-contain" class="ui-widget">
	<p>Ecco la lista delle materie per le quali puoi sostenere esami.</p>
	<p>Clicca su PRENOTA ESAME per prenotarti alla data indicata.</p>
    <div class="column_content">
		<h3>Esami che è possibile prenotare</h3>
        <?php 
			if (count($result['edit']->booking)==0)
			{
				echo "<div style=\"text-align:center;\">";
				echo "<h2>Nessun appello disponibile per il tuo piano di studi</h2>";
				echo "</div>";
			}
		?>
		<div id="bookingTableContainer"></div>
        <h3>Esami prenotati</h3>
        <?php 
			if (count($result['edit']->booked)==0)
			{
				echo "<div style=\"text-align:center;\">";
				echo "<h2>Nessuna prenotazione</h2>";
				echo "</div>";
			}
		?>
        <div id="bookedTableContainer"></div>
		<script type="text/javascript">
		
			var bookingTable=new Table("bookingTable","bookingTableContainer");
			var bookedTable=new Table("bookedTable","bookedTableContainer");
			<?php
				/*************************************************************************
				 * PRENOTABILI
				 *************************************************************************/
				$a = array("Corso","Materia", "Docente", "Data Esame", "Prenota");
				
				for ($i=0;$i<count($a);$i++)
					echo "\nbookingTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
				foreach ($result['edit']->booking as $entry)
				{
					echo "\nbookingTable.colonne[0].addVal(\"".$entry->course_name."\");";
					echo "\nbookingTable.colonne[1].addVal(\"".$entry->subject_name."\");";
					echo "\nbookingTable.colonne[2].addVal(\"".$entry->docente."\");";
					echo "\nbookingTable.colonne[3].addVal(\"".$entry->exam_date."\");";
					echo "\nbookingTable.colonne[4].addVal(\"<center><button onclick='prenota($entry->id);'>Prenota Esame</button></center>\");";			
				}
				
				if (count($result['edit']->booking)>0)
				{
					echo "\nbookingTable.drawTable(false);\n\n";
				}
				
				/*************************************************************************
				 * PRENOTATI
				 *************************************************************************/
				
				$b = array("Corso","Materia", "Docente", "Data Esame", "Data prenotazione");
		
				for ($i=0;$i<count($b);$i++)
					echo "\nbookedTable.colonne[".$i."]=new Column(\"".$b[$i]."\");";
		
				foreach ($result['edit']->booked as $entry)
				{
					echo "\nbookedTable.colonne[0].addVal(\"".$entry->course_name."\");";
					echo "\nbookedTable.colonne[1].addVal(\"".$entry->subject_name."\");";
					echo "\nbookedTable.colonne[2].addVal(\"".$entry->docente."\");";
					echo "\nbookedTable.colonne[3].addVal(\"".$entry->exam_date."\");";
					echo "\nbookedTable.colonne[4].addVal(\"".$entry->book_date."\");";
				}
				
				if (count($result['edit']->booked)>0)
				{
					echo "\nbookedTable.drawTable(false);\n\n";
				}
			?>
	
			function prenota(id)
			{
				document.getElementById('operation').value = "saveBook#"+id;
				document.getElementById('bookingForm').submit();
			}
	    </script>
    </div>
</div>
<br />
<form id="bookingForm" action="index.php" method="post">
	<input id="operation" type="hidden" name="operation" />
</form>
<div class="ui-state-highlight ui-corner-all" style="padding: 0.7em;" >
	<strong><span class="ui-icon ui-icon-info" style="float: left; padding: 1px;"></span>Informazioni:<br /></strong>
	<p style="margin-left: 17px;">Se non trovi un insegnamento in questo elenco <b>DURANTE IL PERIODO DI ESAMI</b>, contattaci.</p>
</div>