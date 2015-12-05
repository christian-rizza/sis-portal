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
	document.location = "index.php?module=course";
}
</script>
<br />
<div class="column">
	<div class="column_content">
        <h3>Inserimento dati:</h3>
	</div>
    <form id="course" action="index.php?module=subject" method="POST">
        <div style="padding-bottom: 20px;">
            <label for="nome">Nome Materia:</label>
            <input type="text" id="nome" name="nome" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->name."\""; ?> />
        </div>
        <div style="padding-bottom: 20px;">
        <label for="descrizione">Descizione:</label>
        <textarea id="descrizione" name="descrizione"><?php if(isset($result['edit'])) echo $result["edit"]->description; ?></textarea>
        </div>
         <?php 
            if (isset($result["edit"]))
            {
				echo "<input type=\"hidden\" name=\"operation\" value=\"editChanges\" />";
                echo "<input type=\"hidden\" name=\"id_materia\" value=\"".$result["edit"]->id."\"/>";
            }
            else
            {
				echo "<input type=\"hidden\" name=\"operation\" value=\"saveChanges\" />";
            }
        ?>
        <div style="text-align:center">
            <button type="submit">Salva</button>
            <button type="button" onclick="abort()">Annulla</button>
        </div>
    </form>
</div>
<div class="column">
    <div class="column_content">
        <h3>Ricerca:</h3>
        <form id="searchForm" action="index.php?module=subject" method="POST">
            <p>
            <label for="search">Cerca Materia:</label>
            <input type="text" id="search" name="search"/>
            </p>
            <div class="button">
                <button type="submit">Cerca</button>
            </div>
     	</form>
	</div>
</div>