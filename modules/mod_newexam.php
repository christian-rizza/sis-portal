<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
 ?>
 
<script>
	function selectStudent() 
	{
		var id = document.getElementById('student').value;
		document.getElementById('id_studente').value=id;
		document.getElementById('operation_new').value="selectStudent";
		document.getElementById('examForm').submit();
	}
	function save()
	{
		document.getElementById('examForm').submit();
	}
	
	
	//JQUERY
	$(function() {
		$( "#data_esame" ).datepicker({
			gotoCurrent: true,
			changeMonth: true,
			changeYear: true,
			showOtherMonths: true,
			selectOtherMonths: true,
		});
 		$( "#data_esame" ).datepicker( $.datepicker.regional[ "it" ] );
	});

</script>

<div class="column">
    <div class="column_content">
        <h3>Selezione dello studente:</h3>
       	<label for="student">Studente:</label>
		<select id="student" onchange="selectStudent();">
        <option value="">Seleziona lo studente...</option>
        <?php
        	foreach ($result['students'] as $student)
            {                        
				$str="<option value=\"".$student->id."\" ";
				if ($result['edit']->student->id==$student->id) 
					$str.=" selected";
				$str.=">".strtoupper($student->surname." ".$student->name)."</option>";
            	echo $str;
			}
		?>
        </select>
        <?php 
			if (isset($result["edit"]->student->id_plan) && $result["edit"]->student->id_plan>0)
			{
		?>
				<p>Lo studente risulta iscritto al
                <strong style="text-transform:uppercase">
        	    <?php echo $result['edit']->student->year; ?>° anno</strong></p>
            	<p>del <strong style="text-transform:uppercase">
				<?php echo $result['edit']->student->course_name; ?></strong></p>
    	        <p>L'anno di prima iscrizione è: <strong style="text-transform:uppercase">
				<?php echo $result['edit']->student->first_year ?></strong></p>
            	<p>Il Piano di studi applicato è: <strong style="text-transform:uppercase">
				<?php echo $result['edit']->planList->plan_code ?></strong></p>
				<p>La durata del corso è di <strong style="text-transform:uppercase">
				<?php echo $result['edit']->student->course_year; ?></strong> anni</p>
		<?php
			}
		?>		
    </div>
</div>
<div class="column">
    <div class="column_content">
		<h3>Selezione degli esami:</h3>
		<form id="examForm" action="index.php?module=exam" method="POST">
        <p>
        	<input type="hidden" id="id_studente" name="id_studente" value="<?php echo $result['edit']->student->id; ?>" />
	        <label for="materia">Materia:</label>
        	<select id="materia" name="id_materia">
	        <option value="">Selezione la materia...</option>
			<?php
			
			//Carico il piano di studi dell'utente selezionato
            foreach ($result['edit']->planList->subjects as $sub)
            {
				$str="<option value=\"".$sub->subject_id."\" ";
				if ($result['edit']->subject_id == $sub->subject_id)
					$str.="selected";
                $str.=">".strtoupper($sub->subject_name)."</option>";
				echo $str;
            }
            ?>
            </select>
		</p>
        <p>
        	<label for="voto">Voto:</label>
            <select id="voto" name="voto" style="width: 173px;">
            <option value="">Seleziona il voto...</option>
            <?php 
				for ($i=18;$i<=30;$i++)
				{
					$str="<option value=\"".$i."\" ";
					if ($result['edit']->vote == $i)
						$str.="selected";
					$str.=">".$i."</option>";
					echo $str;
				}
			?>
            <option value="31" <?php if ($result['edit']->vote==31) echo("selected"); ?>>30 e Lode</option>
            <option value="32" <?php if ($result['edit']->vote==32) echo("selected"); ?>>SENZA VOTO</option>
            <!--  DA MODIFICARE SUCCESSIVAMENTE -->
            <option value="4" <?php if ($result['edit']->vote==4) echo("selected"); ?>>INSUFFICIENTE</option>
            <option value="6" <?php if ($result['edit']->vote==6) echo("selected"); ?>>SUFFICIENTE</option>
            <option value="7" <?php if ($result['edit']->vote==7) echo("selected"); ?>>DISCRETO</option>
            <option value="8" <?php if ($result['edit']->vote==8) echo("selected"); ?>>BUONO</option>
            <option value="9" <?php if ($result['edit']->vote==9) echo("selected"); ?>>OTTIMO</option>
            <option value="10" <?php if ($result['edit']->vote==10) echo("selected"); ?>>ECCELLENTE</option>
            </select>
		</p>
        <p>	
        	<label for="data_esame">Data esame:</label>
			<input type="text" id="data_esame" name="data_esame" style="width: 170px;" <?php echo "value=\"".$result["edit"]->date."\""; ?> /> (gg/mm/aaaa)
        </p>
         <?php 
            if (isset($result["edit"]->subject_id))
            {
                 echo "<input id=\"operation_new\" type=\"hidden\" name=\"operation\" value=\"editChanges\" />";
               	 echo "<input type=\"hidden\" name=\"id_corso\" value=\"".$result["edit"]->id."\"/>";
            }
			else
            {
				 echo "<input id=\"operation_new\" type=\"hidden\" name=\"operation\" value=\"saveChanges\" />";
            }
        ?>
        <div class="button">
        	<button type="button" onclick="save();">Salva</button>
            <button type="reset">Annulla</button>
        </div>
        </form>
    </div>
</div>