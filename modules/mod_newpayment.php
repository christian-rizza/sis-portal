<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
 ?>
<script type="text/javascript">

	var paymentTable = new Table("paymentTable","paymentTableContainer");
	var id_student;
	
	function selectStudent()
	{
		id_student= document.getElementById("student").value;
		document.getElementById('operation_new').value="selectStudent#"+id_student;
		document.getElementById('paymentForm').submit();
	}
	function addPayment()
	{
		var importo = document.getElementById('importo').value;
		var causale = document.getElementById('causale').value;
		var data = document.getElementById('data').value;
		
		addPaymentVal(importo, causale, data);
		$( "button" ).button();
	}
	function addPaymentVal(importo, causale, data)
	{
		id_student= document.getElementById("student").value;
		if (!isNaN(importo) && causale!="" && data!="" && importo!="")
		{
			var rowNum = paymentTable.colonne[0].rows.length;
			paymentTable.colonne[0].addVal(importo);
			paymentTable.colonne[1].addVal(data);
			paymentTable.colonne[2].addVal(causale);
			paymentTable.drawTable(true);
		}
		else
		{
			alert("Inserire correttamente i dati");
		}
	}
	function abort()
	{
		document.location = "index.php?module=payment";
	}
	function save()
	{
		if (!isNaN(id_student) && id_student!=0)
		{
			str=id_student+"#";
			for (i=0;i<paymentTable.colonne[0].length;i++)
			{
				for (j=0;j<paymentTable.colonne.length;j++)
					str+=paymentTable.colonne[j].getVal(i)+":";
				
				//Tolgo l'ultimo carattere
				str=str.substr(0,str.length-1);							// -2 non avevo considerato lo spazio
				str+=",";
			}
			str=str.substr(0,str.length-1);								//Tolgo l'ultimo ritorno		
			document.getElementById("dati").value=str;
			document.getElementById("paymentForm").submit();
		}
		else
		{
			alert("Selezionare uno studente");
		}
	}
	
	//JQUERY
	$(function() {
		$( "#data" ).datepicker({
			gotoCurrent: true,
			changeMonth: true,
			changeYear: true,
			showOtherMonths: true,
			selectOtherMonths: true,
		});
 		$( "#data" ).datepicker( $.datepicker.regional[ "it" ] );
	});
	
</script>
<div class="column">
    <div class="column_content">
        <h3>Selezione dello studente:</h3>
		<p>
        <label for="student">Studente:</label>
        <select id="student" onchange="selectStudent();">
        <option value="">Seleziona lo studente...</option>
        <?php
        foreach ($result['students'] as $student)
        {                        
        	$str="<option value=\"".$student->id."\" ";
            if ($result['edit']->student_id==$student->id) 
            $str.=" selected";
            $str.=">".strtoupper($student->surname." ".$student->name)."</option>";
            echo $str;
		}
		?>
        </select>
       	</p>
        <p>
			<label for="importo">Importo:</label>
			<input type="text" id="importo" name="importo" style="width: 170px;" <?php echo("value=\"". $result["edit"]->value."\""); ?> /> (Es. 123.00)
        </p>
        <p>
        	<label for="data">Data:</label>
            <input type="text" id="data" name="data" style="width: 170px;" <?php echo("value=\"". $result["edit"]->data."\""); ?> /> (gg/mm/aaaa)
        </p>
        <p>
        	<label for="causale">Causale:</label>
           	<input type="text" id="causale" name="causale" <?php echo("value=\"". $result["edit"]->causal."\""); ?> />
        </p>
        <div class="button">
        	<button id="addButton" type="button" onclick="addPayment();">Aggiungi</button>
		</div>
	</div>
</div>
<div class="column">
    <div class="column_content">
		<h3>Pagamenti:</h3>
        <div id="users-contain" style="width:100%" class="ui-widget">
	        <div id="paymentTableContainer"></div>
        </div>
        <script type="text/javascript">
		<?php
			$a = array("Importo (€)","Data", "Causale");
		
			for ($i=0;$i<count($a);$i++)
			{
				echo "paymentTable.colonne[".$i."]=new Column(\"".$a[$i]."\");";
			}
				
			echo "paymentTable.drawTable(true);";
		?>
    	</script>
	</div>
</div>
<div style="clear:both; text-align:center; border-top: 1px solid; padding: 15px;">
	<form id="paymentForm" action="index.php?module=payment" method="POST">
		<input type="hidden" id="dati" name="savePayment" />
         <?php 
            if (isset($result["edit"]))
            {
				echo "<input id=\"operation_new\" type=\"hidden\" name=\"operation\" value=\"editChanges\" />";
                echo "<input type=\"hidden\" name=\"id_studente\" value=\"".$result["edit"]->student_id."\"/>";
            }
            else
            {
                echo "<input id=\"operation_new\" type=\"hidden\" name=\"operation\" value=\"saveChanges\" />";
            }
        ?>
	</form>
	<button id="saveButton" onclick="save();">Salva</button>
	<button id="abortButton" onclick="abort();">Annulla</button>
</div>

<?php

	//Carico le materie se sono in modalita edit
	
	if (isset($result['edit']) && $result['edit']->payment_list>0)
	{
		foreach ($result['edit']->payment_list as $entry)
		{			

			echo "<script type=\"application/javascript\" > addPaymentVal('$entry->value', '$entry->causal', '$entry->date'); </script>";
		}		
	}
?>