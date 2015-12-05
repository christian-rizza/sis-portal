<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
?>
<script type="text/javascript">
function abort()
{
	document.location = "index.php?module=docs";
}


</script>

<div class="column">
	<div class="column_content">
        <h3>Inserimento dati:</h3>
	</div>
    <form method="post" action="index.php?module=docs" enctype="multipart/form-data">
		<input type="hidden" name="operation" value="saveChanges" />
        <p>
        <label for="titolo">Nome Documento:</label>
        <input type="text" id="titolo" name="titolo" />
		</p>
        <p>
        <label for="course">Corso:</label>
        <select id="course" name="course"  onchange="selectCourse();">
				<option value="">Selezione il corso...</option>
                <option value="1">TUTTI</option>
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
        <label for="file">Seleziona il file:</label>
        <input type="file" id="file" name="file">
        </p>
        <div class="button">
            <button type="submit">Salva</button>
            <button type="button" onclick="abort()">Annulla</button>
        </div>
	</form>
</div>
