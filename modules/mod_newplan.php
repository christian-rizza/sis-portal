<script type="text/javascript">

	var subjectTable = new Table("subjectTable","subjectTableContainer");
	var id_course;
	var id_subjects=new Array();
	
	function selectCourse()
	{
		var value = document.getElementById('course').value.split("#");
		
		id_course=value[0];
		if (id_course)
		{			
			document.getElementById('nameCourse').innerHTML=value[1]
			var durata=document.getElementById('durationCourse').innerHTML=value[2];
			
			//Attivo gli elementi bloccati
			document.getElementById('subject').removeAttribute('disabled');
			document.getElementById('years').removeAttribute('disabled');
			
			//Carico il numero di anni all'internod ella select
			var str="<option>Seleziona anno...</option>";
			for (i=0;i<durata;i++)
			{
				str+="<option value=\""+(i+1)+"\">"+(i+1)+"</option>";
			}
		}
		else
		{
			durata="";
			document.getElementById('nameCourse').innerHTML="";
			document.getElementById('durationCourse').innerHTML="";
			document.getElementById('subject').setAttribute('disabled',"");
			document.getElementById('years').setAttribute('disabled',"");
		}
		document.getElementById('years').innerHTML=str;
	}
	function addSubject()
	{
		var subj = document.getElementById('subject').value;
		var year = document.getElementById('years').value;
		
		addSubjectVal(subj, year);
		$( "button" ).button();
		
	}
	function addSubjectVal(subj, year)
	{		
		if (subj!="" && (year!="" && !isNaN(year)))
		{
			var rowNum = subjectTable.colonne[0].rows.length;
			subjectTable.colonne[0].addVal(subj);
			subjectTable.colonne[1].addVal(year);
			subjectTable.drawTable(true);
		}
	}
	function abort()
	{
		document.location = "index.php?module=plan";
	}
	function save()
	{
		str=id_course+"#";
		for (i=0;i<subjectTable.colonne[0].length;i++)
		{
			for (j=0;j<subjectTable.colonne.length;j++)
				str+=subjectTable.colonne[j].getVal(i)+" : ";
			
			//Tolgo l'ultimo carattere
			str=str.substr(0,str.length-2);							// -2 non avevo considerato lo spazio
			str+=",";
		}
		str=str.substr(0,str.length-1);								//Tolgo l'ultimo ritorno
	
		document.getElementById("dati").value=str;
		document.getElementById("codicePiano").value = document.getElementById('codice').value;
		document.getElementById("planForm").submit();
	}
	
</script>
<div class="column">
    <div class="column_content">
        <h3>Selezione del corso:</h3>
        <p>
        	<label for="course">Codice del piano:</label>
	        <input type="text" id="codice" name="codice" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->plan_code."\""; ?> />
        </p>
       	<label for="course">Corso:</label>
		<select id="course" name="course" onchange="selectCourse();">
        <option value="">Selezione il corso...</option>
        <?php
        	foreach ($result['courses'] as $course)
            {                        
				$str="<option value=\"".$course->id."#".$course->name."#".$course->years."\" ";
				if ($result['edit']->course_id==$course->id) 
					$str.=" selected";
				$str.=">".strtoupper($course->name)."</option>";
            	echo $str;
			}
		?>
        </select>
        <hr style="margin-top: 20px;"/>
        
        <p>Corso selezionato: <strong><span id="nameCourse"></span></strong></p>
        <p>Durata del corso: <strong><span id="durationCourse"></span></strong></p>
    </div>
</div>
<div class="column">
    <div class="column_content">
		<h3>Selezione delle materie:</h3>
        <div id="users-contain" style="width:100%" class="ui-widget">
	        <div id="subjectTableContainer"></div>
        </div>
		<script type="text/javascript">
		<?php
			$a = array("Materia","Anno");
		
			for ($i=0;$i<count($a);$i++)
			{
				echo "subjectTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
			}
				
			echo "subjectTable.drawTable(true);";
		?>
    	</script>	
        <p>
        	<select id="subject" name="subject" disabled="disabled">
	        <option value="">Selezione la materia...</option>
			<?php
            foreach ($result['subjects'] as $sub)
            {
                echo "<option value=\"".$sub->name."\">".strtoupper($sub->name)."</option>";
            }
            ?>
            </select>
            <select id="years" name="years" style="width: 190px;" disabled="disabled">
            <option value="">Seleziona anno...</option>
            </select>
		</p>
        <div class="button">
        	<button id="addButton" type="button" onclick="addSubject();">Aggiungi</button>
		</div>
    </div>
</div>
<div style="clear:both; text-align:center; border-top: 1px solid; padding: 15px;">
	<form id="planForm" action="index.php?module=plan" method="POST">
		<input type="hidden" id="dati" name="savePlan" />
        <input type="hidden" id="codicePiano" name="codicePiano" />
         <?php 
            if (isset($result["edit"]))
            {
				echo "<input type=\"hidden\" name=\"operation\" value=\"editChanges\" />";
                echo "<input type=\"hidden\" name=\"id_piano\" value=\"".$result["edit"]->id."\"/>";
            }
            else
            {
                echo "<input type=\"hidden\" name=\"operation\" value=\"saveChanges\" />";
            }
        ?>
	</form>
	<button id="saveButton" onclick="save();">Salva</button>
	<button id="abortButton" onclick="abort();">Annulla</button>
</div>


<?php

	//Carico le materie se sono in modalita edit
	
	if (isset($result['edit']) && $result['edit']->subjects>0)
	{
		foreach ($result['edit']->subjects as $subject)
		{			

			echo "<script type=\"application/javascript\" > addSubjectVal('$subject->subject_name', '$subject->year'); </script>";
			echo "<script type=\"application/javascript\" > selectCourse(); </script>";
		}
		
		
	}
?>