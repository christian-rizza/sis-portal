<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
?>
<div id="users-contain" class="ui-widget">
	<p>Il Sig. <strong><?php echo($result["edit"]->name." ".$result["edit"]->surname)." "; ?></strong>
	nato a  <strong><?php echo($result["edit"]->city_born." "); ?></strong>
	il <strong><?php echo($result["edit"]->date_born)." "; ?></strong>
	è iscritto per l'anno accademico <strong>2011/2012</strong></p>
	<p>al <strong><?php echo($result["edit"]->year)." "; ?> ANNO </strong> 
	del <strong><?php echo($result["edit"]->course_name." "); ?></strong></p>
	<p>L'anno di prima iscrizione è: <strong><?php echo $result['edit']->first_year ?></strong></p>
	<p>Il Piano di studi applicato è: <strong><?php echo strtoupper($result['edit']->plan->plan_code) ?></strong></p>
	<p>La durata del corso è di <strong><?php echo($result["edit"]->course_year)." "; ?> ANNI.</strong></p>
	<br />
	<p style="text-decoration:underline">Il curriculum accademico dell'interessato è il seguente:</p>
	<div class="column_content">
		<h3>Esami di profitto superati per il piano attivo</h3>
        <?php 
			if (count($result['edit']->exam)==0)
			{
				echo "<div style=\"text-align:center;\">";
				echo "<h2>Non risulta sostenuto alcun esame</h2>";
				echo "</div>";
			}
		?>
		<div id="tableExamContainer"></div>
    	<h3>Piano di studi scelto</h3>
        <?php 
			if (count($result['edit']->plan->subjects)==0)
			{
				echo "<div style=\"text-align:center;\">";
				echo "<h2>Il piano di studi non è attivo!</h2>";
				echo "</div>";
			}
		?>
	   	<div id="tablePlanContainer"></div>
		<script type="text/javascript">
			var tablePlan = new Table("tablePlan","tablePlanContainer");
			var tableCourse = new Table("tableCourse","tableExamContainer");
			<?php
		
			$superati = array();
			//Inizializzo la tabella javascript
			$a = array("Codice Ins.","Insegnamento", "Anno Corso","Data","Esito");	
			for ($i=0;$i<count($a);$i++)
				echo "tableCourse.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
			//Modifico la visualizzazione dei voti per lode e approvato
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
			
				//Inserisco gli esami nella tabella
				echo "tableCourse.colonne[0].addVal(\"".$exam->id_subject."\");";
				echo "tableCourse.colonne[1].addVal(\"".$exam->subject_name."\");";
				echo "tableCourse.colonne[2].addVal(\"".$exam->year."\");";
				echo "tableCourse.colonne[3].addVal(\"".$exam->date."\");";
				echo "tableCourse.colonne[4].addVal(\"".$vote."\");";
				
				$superati[] = $exam->id_subject;
			}
		
			if (count($result['edit']->exam)>0)
			{
				echo "tableCourse.drawTable(false);\n\n";
			}
		
			//Inizializzo la tabella javascript
			$b = array("Codice Ins.","Insegnamento", "Anno Corso","Esito");
			for ($j=0;$j<count($b);$j++)
				echo "tablePlan.colonne[".$j."]=new Column(\"".$b[$j]."\");";
		
			foreach ($result['edit']->plan->subjects as $subplan)
			{
				echo "tablePlan.colonne[0].addVal(\"".$subplan->subject_id."\");";
				echo "tablePlan.colonne[1].addVal(\"".$subplan->subject_name."\");";
				echo "tablePlan.colonne[2].addVal(\"".$subplan->year."\");";
				if (in_array($subplan->subject_id,$superati))
					echo "tablePlan.colonne[3].addVal(\"SUPERATO\");";
				else
					echo "tablePlan.colonne[3].addVal(\"--------\");";			
			}
			if (count($result['edit']->plan->subjects)>0)
			{
				echo "tablePlan.drawTable(false);\n\n";
			}
			?>
		</script>
		<form id="formModuleView" action="../OLD/modules/index.php?module=exam" method="POST">
    		<input type="hidden" id="operation" name="operation" /> 
	        <input type="hidden" id="id_studente" name="id_studente" value="<?php echo $result['edit']->student->id ?>" />
    	</form>
        <hr />
		<?php
			if ($exam->year=="*") echo "<p>* L'esame deve essere convalidato d'ufficio poiché il piano di studio dello studente non prevede </p>";
		?>
	</div>
</div>