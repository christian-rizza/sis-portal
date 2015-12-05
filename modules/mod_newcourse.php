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

<div class="column">
	<div class="column_content">
        <h3>Inserimento dati:</h3>
	</div>
    <form id="course" action="index.php?module=course" method="POST">
        <p>
        <label for="nome">Nome Corso:</label>
        <input type="text" id="nome" name="nome" <?php echo("value=\"". $result["edit"]->name."\""); ?> />
        </p>
        <p>
        <label for="tipo">Tipo Corso:</label>
        <select id="tipo" name="tipo">
            <option>Selezionare il tipo di corso...</option>
            <option value="AC" <?php if ($result["edit"]->type=="AC") echo "selected"; ?> >ACCADEMICO</option>
            <option value="BI" <?php if ($result["edit"]->type=="BI") echo "selected"; ?> >BIENNALE</option>
            <option value="AN" <?php if ($result["edit"]->type=="AN") echo "selected"; ?> >ANNUALE</option>
            <option value="PE" <?php if ($result["edit"]->type=="PE") echo "selected"; ?> >PERSONALIZZATO</option>
        </select>
        </p>
        <p>
        <label for="anni">Numero di anni:</label>
        <select id="anni" name="anni" >
            <option>Selezionare il numero di anni...</option>
            <option value="1" <?php if ($result["edit"]->years=="1") echo "selected"; ?> >1</option>
            <option value="2" <?php if ($result["edit"]->years=="2") echo "selected"; ?> >2</option>
            <option value="3" <?php if ($result["edit"]->years=="3") echo "selected"; ?> >3</option>
            <option value="4" <?php if ($result["edit"]->years=="4") echo "selected"; ?> >4</option>
            <option value="5" <?php if ($result["edit"]->years=="5") echo "selected"; ?> >5</option>
        </select>
        </p>
        <?php 
            if (isset($result["edit"]->id))
            {
                echo "<input type=\"hidden\" name=\"operation\" value=\"editChanges\" />";
                echo "<input type=\"hidden\" name=\"id_corso\" value=\"".$result["edit"]->id."\"/>";
            }
            else
            {
				echo "<input type=\"hidden\" name=\"operation\" value=\"saveChanges\" />";
            }
        ?>
        <div class="button">
            <button type="submit">Salva</button>
            <button type="button" onclick="abort()">Annulla</button>
        </div>
    </form>
</div>
<div class="column">
    <div class="column_content">
        <h3>Ricerca:</h3>
        <form id="searchForm" action="index.php?module=course" method="POST">
            <p>
            <label for="search">Cerca Corso:</label>
            <input type="text" id="search" name="search" />
            </p>
            <div class="button">
                <button type="submit">Cerca</button>
            </div>
     	</form>
	</div>
</div>