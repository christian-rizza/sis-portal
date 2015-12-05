<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
?>
<script>
<?php
	if (isset($result['plans']))
	{
		echo "var planList=new Array();";
		foreach ($result['plans'] as $plan)
		{                        
			echo "planList.push(\"".$plan->id."#".$plan->course_id."#".$plan->plan_code."\");";
		}
	}
?>
	function removePlan()
	{
		//document.getElementById('course').setAttribute('disabled','');
		document.getElementById('years').setAttribute('disabled','');
		document.getElementById('plan').setAttribute('disabled','');
		
		document.getElementById('course').value=document.getElementById('course').options[0].value;
		document.getElementById('years').value=document.getElementById('years').options[0].value;
		document.getElementById('plan').value=document.getElementById('plan').options[0].value;
		
	}
	function selectCourse()
	{
		var value = document.getElementById('course').value.split("#");
				
		id_course=value[0];
		if (id_course)
		{			
			document.getElementById('nameCourse').innerHTML=value[1]
			var durata=document.getElementById('durationCourse').innerHTML=value[2];
			
			//Carico il numero di anni all'interno ella select
			document.getElementById('years').removeAttribute('disabled');
			document.getElementById('plan').removeAttribute('disabled');
			var anno="<option>Seleziona anno...</option>";
			for (i=0;i<durata;i++)
			{
				anno+="<option value=\""+(i+1)+"\" ";
				<?php 
				if(isset($result['edit']->year))
				{
					echo "if ((i+1)==".$result['edit']->year.")";
					echo "anno+=\"selected\";";
				}
				?>
				anno+=">"+(i+1)+"</option>";
			}
			
			//Filtro i piani di studio per il corso scelto
			var current_id_plan=document.getElementById('plan').value;
			str="<option>Selezione il piano di studi...</option>";
			for (i=0;i<planList.length;i++)
			{
				field = planList[i].split("#");
				id_plan = field[0];
				new_id_course = field[1];
				option_inner = field[2];
				if (id_course==new_id_course)
				{
					str+="<option value=\""+(id_plan)+"\" ";
					if (id_plan==current_id_plan)
						str+="selected";
					str+=">"+option_inner+"</option>";
				}
			}
			document.getElementById('plan').innerHTML=str;
		}
		else
		{
			durata="";
			document.getElementById('nameCourse').innerHTML="";
			document.getElementById('durationCourse').innerHTML="";
			document.getElementById('subject').setAttribute('disabled',"");
			document.getElementById('years').setAttribute('disabled',"");
		}
		document.getElementById('years').innerHTML=anno;
	}
	function abort()
	{
		document.location = "index.php?module=student";
	}
	$(function() {
		$( "#data_nascita" ).datepicker({
			yearRange: '1900',
			gotoCurrent: true,
			changeMonth: true,
			changeYear: true,
			showOtherMonths: true,
			selectOtherMonths: true,
		});
 		$( "#data_nascita" ).datepicker( $.datepicker.regional[ "it" ] );
		$( "#data_titolo" ).datepicker({
			gotoCurrent: true,
			changeMonth: true,
			changeYear: true,
			showOtherMonths: true,
			selectOtherMonths: true,
		});
 		$( "#data_titolo" ).datepicker( $.datepicker.regional[ "it" ] );
	});
</script>
<div id="tabs" style="margin: 20px;" >
	<ul>
		<li><a href="#tabs-1">Generale</a></li>
        <li><a href="#tabs-2">Residenza</a></li>
        <li><a href="#tabs-3">Istruzione</a></li>
        <li><a href="#tabs-4">Iscrizione</a></li>
        <li><a href="#tabs-5">Password</a></li>
	</ul>
   	<form id="studentForm" action="index.php?module=student" method="POST">
    <div id="tabs-1">
    	<div class="column_content">
        <h3>Dati Anagrafici:</h3>
        	<p>
			<label for="nome" style="vertical-align: bottom;">Foto:</label>
			<img id="foto" alt="foto_profilo" 
				<?php 
					if (isset($result['edit']->foto))
						echo 'src="../'.$result['edit']->foto.'"';
					else
						echo 'src="../img/no_pic.jpg"';
				?>
			style="width: 150px" />
			</p>
			<p>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome"  <?php echo "value=\"".$result["edit"]->name."\""; ?> />
            </p>
            <p>
                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" name="cognome"  <?php echo "value=\"".$result["edit"]->surname."\""; ?> />
            </p>
            <p>
                <label for="sesso">Sesso:</label>
                <select id="sesso" name="sesso">
                    <option>Seleziona...</option>
                    <option value="M" <?php if ($result["edit"]->sex=="M") echo "selected"; ?>>Maschile</option>
                    <option value="F" <?php if ($result["edit"]->sex=="F") echo "selected"; ?>>Femminile</option>
                </select>
            </p>
            <p>
                <label for="prov_nascita">Prov. nascita: </label>
                <select id="prov_nascita" name="prov_nascita" ></select>
                <script type="application/javascript">
					var p = new Province();
					p.getHtmlList("prov_nascita","<?php if(isset($result['edit'])) echo $result['edit']->prov_born ?>");
				</script>
            </p>
            <p>
                <label for="luogo_nascita">Luogo di nascita:</label>
                <input type="text" id="luogo_nascita" name="luogo_nascita"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->city_born."\""; ?> />
            </p>
            <p>
                <label for="data_nascita">Data di nascita:</label>
                <input type="text" id="data_nascita" name="data_nascita" style="width: 175px;" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->date_born."\""; ?> /> (gg/mm/aaaa)
            </p>
            <p>
                <label for="cf">Codice Fiscale:</label>
                <input type="text" id="cf" name="cf"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cf."\""; ?> />
            </p>
		</div>
	</div>
    <div id="tabs-2">
    	<div class="column_content">
        <h3>Indirizzo di residenza:</h3>
        	<p>
	        	<label for="indirizzo">Via o Piazza - N. Civico:</label>
	    	    <input type="text" id="indirizzo" name="indirizzo"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->address."\""; ?> />
			</p>
			<p>
	        	<label for="citta_residenza">Comune:</label>
	    	    <input type="text" id="citta_residenza" name="citta_residenza"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->city_res."\""; ?> />
			</p>
			<p>
	        	<label for="prov_residenza">Provincia:</label>
                <select id="prov_residenza" name="prov_residenza" ></select>
                <script type="application/javascript">
					var p = new Province();
					p.getHtmlList("prov_residenza","<?php if(isset($result['edit'])) echo $result['edit']->prov_res ?>");
				</script>
			</p>
			<p>
	        	<label for="cap">CAP:</label>
    	    	<input type="text" id="cap" name="cap" style="width: 100px;" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cap."\""; ?> />
        	</p>
        	<p>
	        	<label for="tel">Telefono:</label>
    	    	<input type="text" id="tel" name="tel"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->tel."\""; ?> />
			</p>
            <p>
				<label for="email">Email: </label>
				<input type="text" id="email" name="email"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->email."\""; ?> />
			</p>
        	<p>
	        	<label for="cell_p">Cellulare personale:</label>
    	    	<input type="text" id="cell_p" name="cell_personale"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cell_personal."\""; ?> />
        	</p>
			<p>
	        	<label for="cell_g">Cellulare genitore:</label>
    	    	<input type="text" id="cell_g" name="cell_genitore"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cell_parent."\""; ?> />
			</p>
		</div>
	</div>
    <div id="tabs-3">
	    <div class="column_content">
        <h3>Istruzione e Formazione:</h3>
        	<p>
				<label for="nome_titolo">Titolo di studio: </label>
				<input type="text" id="nome_titolo" name="nome_titolo"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->nome_titolo."\""; ?> />
			</p>
			<p>
				<label for="data_titolo">Titolo conseguito il:</label>
				<input type="text" id="data_titolo" name="data_titolo" style="width: 175px;" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->data_titolo."\""; ?> />  (gg/mm/aaaa)
			</p>
			<p>
				<label for="nome_istituto">Istituto di provenienza:</label>
				<input type="text" id="nome_istituto" name="nome_istituto"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->nome_istituto."\""; ?> />
			</p>
			<p>
				<label for="citta_istituto">Città:</label>
				<input type="text" id="citta_istituto" name="citta_istituto"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->citta_istituto."\""; ?> />
			</p>
			<p>
				<label for="esperienze">Esperienza lavorative:</label>
                <textarea id="esperienze" name="esperienze"><?php if(isset($result['edit'])) echo $result["edit"]->experience; ?></textarea>
			</p>
			<p>
				<label for="lingue">Conoscenza Linguistiche:</label>
				<textarea id="lingue" name="lingue"><?php if(isset($result['edit'])) echo $result["edit"]->languages; ?></textarea>
			</p>
			<p>
				<label for="informatica">Conoscenza Informatiche: </label>
				<textarea id="informatica" name="informatica"><?php if(isset($result['edit'])) echo $result["edit"]->computer;?> </textarea>
			</p>
        </div>
	</div>
    <div id="tabs-4">
	    <div class="column">
            <div class="column_content">
                <h3>Iscrizione e Piani di Studio:</h3>
                <?php 
                    if (isset($result["edit"]->id_plan) && $result["edit"]->id_plan>0) {
                        
                        ?>
                            <p>Lo studente <strong style="text-transform:uppercase">
							<?php echo $result["edit"]->name." ".$result["edit"]->surname; ?></strong> 
                            risulta iscritto al 
                            <strong style="text-transform:uppercase">
                            <?php echo $result['edit']->year; ?>° anno</strong></p>
                            <p>del <strong style="text-transform:uppercase">
							<?php echo $result['edit']->course_name; ?></strong></p>
                            <p>L'anno di prima iscrizione è: <strong style="text-transform:uppercase">
							<?php echo $result['edit']->first_year ?></strong></p>
                            <p>Il Piano di studi applicato è: <strong style="text-transform:uppercase">
							<?php echo sprintf("%010d",$result['edit']->id_plan) ?></strong></p>
                            <p>La durata del corso è di <strong style="text-transform:uppercase">
							<?php echo $result['edit']->course_year; ?></strong> anni</p>
                        <?php
                    }
                    else {
                        
                        ?>
                            <p>Lo studente <strong><?php echo $result["edit"]->name." ".$result["edit"]->surname; ?></strong> non risulta ancora iscritto</p>
                        <?php
                        
                    }
                ?>
            </div>
        </div>
        <div class="column">
            <div class="column_content">
                <h3>Modifica dati di iscrizione</h3>
                <p>
                    <label for="first_year">Anno Prima iscrizione:</label>
                    <input type="text" id="first_year" name="prima_iscrizione" style="width: 100px;" <?php echo "value=\"".$result["edit"]->first_year."\""; ?> /> 
                </p>
                <p>
                <label for="course">Corso:</label>
                <select id="course" name="course"  onchange="selectCourse();">
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
                </p>
                <p>
                <label for="plan">Piano di studi:</label>
                <select id="plan" name="id_piano"  disabled onchange="selectPlan();">
                <option value="">Selezione il piano di studi...</option>
                <?php
                	if (isset($result['edit']->id_plan))
						echo "<option value=\"".$result['edit']->id_plan."\" selected>".strtoupper($result['edit']->plan_code)."</option>";
				?>
                </select>
                </p>
                <p>
                <label for="years">Anno di iscrizione</label>
                <select id="years" name="anno_iscrizione" disabled="disabled">
	            <option value="">Seleziona anno...</option>
    	        </select>
                </p>
                <hr style="margin-top: 20px;"/>
                
                <p>Corso selezionato: <strong><span id="nameCourse"></span></strong></p>
                <p>Durata del corso: <strong><span id="durationCourse"></span></strong></p>
                
                <div class="button">
                	<button type="button" onclick="removePlan();">Rimuovi Iscrizione</button>
                </div>
            </div>
		</div>
	</div>
    <div id="tabs-5">
		<div class="column_content">
        <h3>Cambio Password</h3>
       	<p>Cliccando sul pulsante <strong>GENERA PASSWORD</strong> verrà  generata una nuova password per lo studente.</p>
        <p>Lo Studente riceverà immediatamente una mail con la nuova password d'accesso!</p>
		       	<button type="button" onclick="document.getElementById('newPass').submit();">GENERA PASSWORD</button>
        </div>
	</div>
    
    <div style="clear:both; text-align:center; border-top: 1px solid; padding: 15px;">
         <?php 
            if (isset($result["edit"]) && isset($result["edit"]->id))
            {
                echo "<input type=\"hidden\" name=\"operation\" value=\"editChanges\" />";
                echo "<input type=\"hidden\" name=\"id_studente\" value=\"".$result["edit"]->id."\"/>";
            }
            else
            {
                echo "<input type=\"hidden\" name=\"operation\" value=\"saveChanges\" />";
            }
        ?>
		<div class="button">
			<button type="submit">Salva</button>
			<button type="button" onclick="abort();">Annulla</button>
		</div>
	</div>
    </form>
	<form id="newPass" action="index.php?module=student" method="POST">
		<input type="hidden" name="operation" value="createPassword#<?php echo $result['edit']->id; ?>" />
    </form>
</div>

<?php

	//Carico le materie se sono in modalita edit
	
	if (isset($result['edit']))
	{
		echo "<script type=\"application/javascript\" > selectCourse(); </script>";
	}
?>