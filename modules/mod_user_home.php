<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<p>L'Accademia Euromediterranea, al fine di agevolare l'interazione con lo studente, mette a disposizione una serie di servizi on-line.<br>
I servizi sono disponibili 24 ore su 24 e in tempo reale.</p>
<hr />
	
<div class="column_content">
	<h3>Messaggi Personali</h3>
	<?php
	$countPrivate=0; 
	$countPublic=0;
	foreach ($result['edit']->notice as $notice)
	{	
		if (in_array($result['edit']->id, explode(";",$notice->id_dest)))
		{
			echo "<div id=\"effect\" class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0.7em;\" >";
			echo "<strong><span class=\"ui-icon ui-icon-info\" style=\"float: left; padding: 1px;\"></span>$notice->title<br /></strong>";
			echo "<p style=\"margin-left: 17px;\">$notice->text</p>";
			echo "</div>";
			echo "<br />";
			$countPrivate++;
		}
	}
	if ($countPrivate==0)
	{
		echo "<div id=\"effect\" class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0.7em;\" >";
		echo "<strong><span class=\"ui-icon ui-icon-info\" style=\"float: left; padding: 1px;\"></span>Informazioni:<br /></strong>";
		echo "<p style=\"margin-left: 17px;\">Nessun messaggio personale</p>";
		echo "</div>";
		echo "<br />";
	}
	?>
    <h3>Avvisi Vari</h3>
    <?php
	foreach ($result['edit']->notice as $notice)
	{	
		if ($notice->id_dest==0)
		{
			echo "<div id=\"effect\" class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0.7em;\" >";
			echo "<strong><span class=\"ui-icon ui-icon-info\" style=\"float: left; padding: 1px;\"></span>$notice->title<br /></strong>";
			echo "<p style=\"margin-left: 17px;\">$notice->text</p>";
			echo "</div>";
			echo "<br />";
			$countPublic++;
		}
	}
	
	if (count($result['edit']->notice)==0)
	{
		echo "<div id=\"effect\" class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0.7em;\" >";
		echo "<strong><span class=\"ui-icon ui-icon-info\" style=\"float: left; padding: 1px;\"></span>Informazioni:<br /></strong>";
		echo "<p style=\"margin-left: 17px;\">Nessun avviso</p>";
		echo "</div>";
		echo "<br />";
	}
	
	?>
</div>