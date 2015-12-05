<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
?>
<script>
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
	});
</script>
<div class="column">
    <div class="column_content">
        <h3>Dati Anagrafici:</h3>
        <form id="student" action="index.php?module=student" method="POST">
            <p>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->name."\""; ?> />
            </p>
            <p>
                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" name="cognome"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->surname."\""; ?> />
            </p>
            <p>
                <label for="sesso">Sesso:</label>
                <select id="sesso" name="sesso">
                    <option>Seleziona...</option>
                    <option value="M">Maschile</option>
                    <option value="F">Femminile</option>
                </select>
            </p>
            <p>
                <label for="prov_nascita">Prov. nascita: </label>
                <select id="prov_nascita" name="prov_nascita" ></select>
                <script type="application/javascript">
					var p = new Province();
					p.getHtmlList("prov_nascita");
				</script>
            </p>
            <p>
                <label for="luogo_nascita">Luogo di nascita:</label>
                <input type="text" id="luogo_nascita" name="luogo_nascita"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->name."\""; ?> />
            </p>
            <p>
                <label for="data_nascita">Data di nascita:</label>
                <input type="text" id="data_nascita" name="data_nascita" style="width: 175px;"/> (gg/mm/aaaa)
            </p>
            <p>
                <label for="cf">Codice Fiscale:</label>
                <input type="text" id="cf" name="cf"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->name."\""; ?> />
            </p>
            <?php 
            if (isset($result["edit"]))
            {
                echo "<input type=\"hidden\" name=\"operation\" value=\"editChanges\" />";
                echo "<input type=\"hidden\" name=\"id_corso\" value=\"".$result["edit"]->id."\"/>";
            }
            else
            {
                echo "<input type=\"hidden\" name=\"operation\" value=\"nextPage\" />";
            }
	        ?>
            <div class="button">
            <button type="submit">Prosegui</button>
            <button type="reset">Annulla</button>
        </div>
    </form>
    </div>
</div>
<div class="column">
    <div class="column_content">
        <h3>Ricerca:</h3>
        <form id="searchForm" action="index.php?module=student" method="POST">
            <p>
            <label for="search">Cerca Studente:</label>
            <input type="text" id="search" name="search"  />
            </p>
            <div class="button">
                <button type="submit">Cerca</button>
            </div>
     	</form>
	</div>
</div>


<?php

	//Carico le materie se sono in modalita edit
	
	if (isset($result['edit']) && $result['edit']->subjects>0)
	{
		foreach ($result['edit']->subjects as $subject)
		{
			list($year, $name) = explode("#",$subject);
			echo "<script type=\"application/javascript\" > addSubjectVal('$name', '$year'); </script>";
			echo "<script type=\"application/javascript\" > selectCourse(); </script>";
		}
		
		
	}
?>