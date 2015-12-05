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
		<li><a href="#tabs-1">Nuovo Appello</a></li>
	</ul>
	<div id="tabs-1">
		<?php include_once BASE_PATH."/modules/mod_newbook.php" ?>
	</div>
</div>

<div id="tabs2" style="margin: 20px;">
	<div class="column_content">
		<h3>Appelli attivi:</h3>
        <?php include_once BASE_PATH."/modules/mod_booking.php"; ?>
	</div>
</div>
<form id="formModuleView" action="index.php?module=booking" method="POST">
   	<input type="hidden" id="operation" name="operation" />
</form>