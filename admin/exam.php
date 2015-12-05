<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

if (!isset($_SESSION['admin']))
{
	header("Location: ../index.php");
}

?>

<div id="tabs" style="margin: 20px;">
	<ul>
		<li><a href="#tabs-1">Nuova Esame</a></li>
	</ul>
	<div id="tabs-1">
		<?php include_once BASE_PATH."/modules/mod_newexam.php" ?>
	</div>
</div>

<div id="tabs2" style="margin: 20px;">
	<div class="column_content">
		<h3>Carriera Studente:</h3>
        <?php 
			if (isset($result['edit']->student))
			{
				include_once BASE_PATH."/modules/mod_career.php"; 
			}
			else
			{
				echo "<div style=\"text-align:center;\">";
				echo "<h2>Selezionare uno studente</h2>";
				echo "</div>";
			}
		?>
	</div>
</div>
