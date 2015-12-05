<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<div id="users-contain" class="ui-widget">
	<div id="documentTableContainer"></div>
	<script type="text/javascript">
	var documentTable=new Table("documentTable","documentTableContainer");
	<?php
		$a = array("Didascalia","Corso","Collegamento","Elimina");
		
		
		for ($i=0;$i<count($a);$i++)
			echo "documentTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['docs'] as $doc)
		{
			echo "documentTable.colonne[0].addVal(\"".$doc->title."\");";
			echo "documentTable.colonne[1].addVal(\"".$doc->course_name."\");";
			echo "documentTable.colonne[2].addVal(\"<a href='".$doc->path."' target='_blank'><button>Visualizza</button></a>\");";
			echo "documentTable.colonne[3].addVal(\"<center><button onclick='deleteFromView($doc->id);'>Elimina</button></center>\");";
		}
		echo "documentTable.drawTable(false);\n\n";
	?>
    </script>
</div>