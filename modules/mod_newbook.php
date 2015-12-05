<script type="text/javascript">
	var planList = new Array();
	
	function selectPlan()
	{
		var id = document.getElementById('plan').value;
		for (i=0;i<planList.length;i++)
		{
			if (planList[i].id==id)
			{
				var subjectList = planList[i].subjects;
				var html = "<option>Selezione la materia...</option>";
				for (i=0;i<subjectList.length;i++)
				{
					var subject = subjectList[i];
					html+="<option value=\""+subject.subject_id+"#"+subject.year+"\">"+subject.subject_name.toUpperCase()+"</option>";
				}
			}
		}
		document.getElementById('materia').innerHTML=html;
		document.getElementById('materia').removeAttribute('disabled');
	}
	function updatePlan()
	{				
		var html = "<option>Selezione il piano di studi...</option>";
		for (i=0;i<planList.length;i++)
		{
			var plan = planList[i];
			html+="<option value=\""+plan.id+"\">"+plan.plan_code.toUpperCase()+"</option>";
		}
		document.getElementById('plan').innerHTML=html;
		document.getElementById('plan').removeAttribute('disabled');
	}
	function selectCourse()
	{
		$.ajax(
		{
			type: "POST",
			url: "index.php?module=booking",
			data: "operation=getAjaxPlanList#"+document.getElementById('course').value.split("#")[0],
			success: function(response)
			{
				planList = eval("("+response+")");
				updatePlan();
			},
			error: function(response)
			{
				
			}
			
		});
	}
	
	function save()
	{
		var subject = document.getElementById('materia').options[document.getElementById('materia').selectedIndex].text;
		var docente = document.getElementById('docente').value;
		var data = document.getElementById('data_esame').value;
		
		if (subject!="" && docente!="" && data!="")
		{
			document.getElementById('booking').submit();
		}
		else
		{
			alert("Inserire correttamente i dati");
		}
	}
	
	//JQUERY
	$(function() {
		$( "#data_esame" ).datepicker({
			gotoCurrent: true,
			changeMonth: true,
			changeYear: true,
			showOtherMonths: true,
			selectOtherMonths: true,
		});
 		$( "#data_esame" ).datepicker( $.datepicker.regional[ "it" ] );
	});
</script>
<div id="output">
	
</div>
<div class="column">
    <div class="column_content">
    	<form id="booking" action="index.php?module=booking" method="POST">
        <h3>Creazione Appello:</h3>
		<p>
			<label for="course">Corso:</label>
			<select id="course" name="course"  onchange="selectCourse();">
				<option value="">Selezione il corso...</option>
                <?php
                    foreach ($result['courses'] as $course)
                    {                        
                        $str="<option value=\"".$course->id."\" ";
                        if ($result['edit']->course_id==$course->id) 
                            $str.=" selected";
                        $str.=">".strtoupper($course->name)."</option>";
                        echo $str;
                    }
                ?>
			</select>
		</p>
		<p>
			<label for="plan">Piano di studi:</label>
			<select id="plan" name="id_piano" onchange="selectPlan();" disabled="disabled"></select>
		</p>
        <p>
	        <label for="materia">Materia:</label>
        	<select id="materia" name="id_materia" disabled="disabled"></select>
		</p>
        <p>	
        	<label for="docente">Docente:</label>
			<input type="text" id="docente" name="docente" <?php echo "value=\"".$result["edit"]->date."\""; ?> />
        </p>
        <p>	
        	<label for="data_esame">Data esame:</label>
			<input type="text" id="data_esame" name="data_esame" style="width: 170px;" <?php echo "value=\"".$result["edit"]->date."\""; ?> /> (gg/mm/aaaa)
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
        	<button type="button" onclick="save();">Crea Appello</button>
        </div>
        </form>
	</div>
</div>