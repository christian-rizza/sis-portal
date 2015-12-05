<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<div id="users-contain" class="ui-widget">
	<div id="noticeTableContainer"></div>
	<script type="text/javascript">
	var noticeTable=new Table("noticeTable","noticeTableContainer");
	<?php
		$a = array("Codice","Titolo","Testo","Destinatario","Mail Inviata","Elimina");
		
		
		for ($i=0;$i<count($a);$i++)
			echo "noticeTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
		
		foreach ($result['notices'] as $notice)
		{
			echo "noticeTable.colonne[0].addVal(\"".$notice->id."\");";
			echo "noticeTable.colonne[1].addVal(\"".$notice->title."\");";
			echo "noticeTable.colonne[2].addVal(\"".$notice->text."\");";
			
			//preparo i destinatari da visualizzare
			$lista = explode(";",$notice->id_dest);
			$lista_nomi = array();
			foreach ($lista as $dest)
			{
				if ($dest==0)
					$lista_nomi[] = "TUTTI GLI STUDENTI";
				else
				foreach ($result['students'] as $student)
				{
					if ($student->id == $dest)
					{
						$lista_nomi[] = $student->surname." ".$student->name;
					}
				}
			}	 
			
			//echo "noticeTable.colonne[3].addVal(\"".$notice->id_dest."\");";
			echo "noticeTable.colonne[3].addVal(\"".implode('<br /><hr />',$lista_nomi)."\");";
			echo "noticeTable.colonne[4].addVal(\"".($notice->mail_send ? 'SI' : 'NO')."\");";
			echo "noticeTable.colonne[5].addVal(\"<center><button onclick='deleteFromView($notice->id);'>Elimina</button></center>\");";
		}
		echo "noticeTable.drawTable(false);\n\n";
	?>
    </script>
</div>