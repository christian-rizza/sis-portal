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



<div id="tabs2" style="margin: 20px;">
	<div class="column_content">
		<h3>Esami prenotati:</h3>
        <?php include_once BASE_PATH."/modules/mod_booked.php"; ?>
	</div>
</div>
<form id="formModuleView" action="index.php?module=booked" method="POST">
   	<input type="hidden" id="operation" name="operation" />
</form>