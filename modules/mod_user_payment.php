<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>

<p>Questo servizio ti consente di poter prendere visione delle tasse che hai versato per l'accademia.</p>


<div id="users-contain" class="ui-widget">
	<div id="paymentTableContainer"></div>
	<script type="text/javascript">
	var paymentTable=new Table("paymentTable","paymentTableContainer");
	<?php
		$a = array("Importo (€)","Data", "Causale");
		
		for ($i=0;$i<count($a);$i++)
			echo "\npaymentTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['edit']->payment->payment_list as $entry)
		{
			echo "\npaymentTable.colonne[0].addVal(\"".number_format($entry->value,2)."\");";
			echo "\npaymentTable.colonne[1].addVal(\"".$entry->date."\");";
			echo "\npaymentTable.colonne[2].addVal(\"".$entry->causal."\");";
		}
		echo "\npaymentTable.drawTable(false);\n\n";
	?>
    </script>
</div>
<br />
<div class="ui-state-highlight ui-corner-all" style="padding: 0.7em;" >
	<strong><span class="ui-icon ui-icon-info" style="float: left; padding: 1px;"></span>Informazioni:<br /></strong>
	<p style="margin-left: 17px;">Attenzione queste informazioni potrebbero non essere agiornate alla data odierna.</p>
</div>
