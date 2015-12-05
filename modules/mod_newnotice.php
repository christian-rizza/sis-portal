<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
?>
<script type="text/javascript">
function abort()
{
	document.location = "index.php?module=notice";
}
</script>

<form id="course" action="index.php?module=notice" method="POST">

<div class="column">
	<div class="column_content">
        <h3>Inserimento dati:</h3>
	</div>
        <p>
        <label for="titolo">Titolo Avviso:</label>
        <input type="text" id="titolo" name="titolo" style="text-transform: none;" value="Informazioni">
        </p>
        <p>
        <label for="testo" style="text-transform:none">Testo Avviso:</label>
        <textarea id="testo" name="testo" style="text-transform: none;"></textarea>
        </p>
</div>
<div class="column">
    <div class="column_content">
        <h3>Ricerca:</h3>
        <p>
            <label for="destinatario">Destinatario:</label>
            <select id="destinatario" name="destinatario[]" multiple="multiple" style="height: 200px;">
                <option value="0">TUTTI GLI STUDENTI</option>
                <?php

                	function cmp($a, $b)
					{
    					return strcasecmp($a->surname, $b->surname);
					}
					usort($result['students'], "cmp");
					
					foreach ($result['students'] as $stud)
					{
						echo "<option value=\"".$stud->id."\">".strtoupper($stud->surname." ".$stud->name)."</option>";
					}
				?>
            </select>
        </p>
        <p>
        	<label for="invio_mail">Inviare una mail?:</label>
            <input type="checkbox" id="invio_mail" name="invio_mail" style="width: auto;"/>
        </p>
	</div>
</div>
<div style="clear:both; text-align:center; border-top: 1px solid; padding: 15px;">
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
	<button type="submit" id="saveButton" onclick="save();">Salva</button>
	<button type="button" id="abortButton" onclick="abort();">Annulla</button>
</div>
</form>