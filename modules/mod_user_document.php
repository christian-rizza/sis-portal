<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<div id="users-contain" class="ui-widget">
<p>Potete scaricare i seguenti documenti e moduli messi a disposizione dalla segreteria:</p>
<hr />
<div style="text-align:center">
<?php

foreach ($result['edit']->document as $doc)
{
	if ($doc->type==1 || $doc->type==$result['edit']->course_id)
	echo "<p style=\"font-size: 14px;\"><strong><a href=\"".BASE_PATH."/".$doc->path."\">".strtoupper($doc->title)."</a></strong></p>";
	
}
?>
</div>
</div>
