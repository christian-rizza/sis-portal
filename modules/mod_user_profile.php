<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>
<script type="text/javascript" src="js/ajaxupload.3.5.js"></script>
<script type="text/javascript">

	function abort()
	{
		document.location = "index.php";
	}
	$(function()
	{
		var btnUpload=$('#upload');
		new AjaxUpload(btnUpload, {
			action: 'upload-file.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)))
				 { 
                    // extension is not allowed 
					alert('Only JPG, PNG or GIF files are allowed');
					return false;
				 }
			},
			onComplete: function(file, response)
			{
				//Add uploaded file to list
				var array = response.split("#");
				if(array[0]==="success")
				{
					//$('<li></li>').appendTo('#foto').html('caricato<br />'+file);
					$('#foto').attr('src', array[1]);
					$('#foto_input').val(array[1]);
				}
				else
				{
					alert(response);
				}
			}
		});
		
	});
		
	
</script>
<form id="studentForm" action="index.php" method="POST">    
<div class="column_content">
	<h3>Dati Personali:</h3>
    <div>
    	<p>
			<label for="nome" style="vertical-align: bottom;">Foto:</label>
			<img id="foto" alt="foto_profilo" 
				<?php 
					if (isset($result['edit']->foto))
						echo 'src="'.$result['edit']->foto.'"';
					else
						echo 'src="img/no_pic.jpg"';
				?>
				 
			style="width: 150px" />
			<input type="hidden" id="foto_input" name="foto" />
			<button id="upload">Cambia Foto</button>
		</p>
	    <p>
			<label for="nome">Nome:</label>
			<input type="text" id="nome" disabled="disabled"  <?php echo "value=\"".$result["edit"]->name."\""; ?> />
		</p>
    	<p>
			<label for="cognome">Cognome:</label>
			<input type="text" id="cognome" disabled="disabled"  <?php echo "value=\"".$result["edit"]->surname."\""; ?> />
		</p>
		<p>
			<label for="sesso">Sesso:</label>
			<select id="sesso" disabled="disabled">
				<option>Seleziona...</option>
				<option value="M" <?php if ($result["edit"]->sex=="M") echo "selected"; ?> >MASCHILE</option>
				<option value="F" <?php if ($result["edit"]->sex=="F") echo "selected"; ?> >FEMMINILE</option>
			</select>
		</p>
		<p>
			<label for="prov_nascita">Prov. nascita: </label>
			<select id="prov_nascita" disabled="disabled" ></select>
			<script type="application/javascript">
				var p = new Province();
				p.getHtmlList("prov_nascita","<?php if(isset($result['edit'])) echo $result['edit']->prov_born ?>");
			</script>
		</p>
		<p>
			<label for="luogo_nascita">Luogo di nascita:</label>
			<input type="text" id="luogo_nascita" disabled="disabled" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->city_born."\""; ?> />
		</p>
		<p>
			<label for="data_nascita">Data di nascita:</label>
			<input type="text" id="data_nascita" style="width: 175px;" disabled="disabled" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->date_born."\""; ?> /> (gg/mm/aaaa)
		</p>
		<p>
			<label for="cf">Codice Fiscale:</label>
			<input type="text" id="cf" disabled="disabled" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cf."\""; ?> />
		</p>
        <p>
			<label for="password">Nuova Password:</label>
			<input type="password" id="password" name="password" />
		</p>
	</div>
    <h3>Residenza:</h3>
    <div>
        <p>
	        <label for="indirizzo">Via o Piazza - N. Civico:</label>
	    	<input type="text" id="indirizzo" name="indirizzo"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->address."\""; ?> />
		</p>
		<p>
	       	<label for="citta_residenza">Comune:</label>
	        <input type="text" id="citta_residenza" name="citta_residenza"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->city_res."\""; ?> />
		</p>
		<p>
	       	<label for="prov_residenza">Provincia:</label>
			<select id="prov_residenza" name="prov_residenza" ></select>
			<script type="application/javascript">
				var p = new Province();
				p.getHtmlList("prov_residenza","<?php if(isset($result['edit'])) echo $result['edit']->prov_res ?>");
			</script>
		</p>
		<p>
			<label for="cap">CAP:</label>
			<input type="text" id="cap" name="cap" style="width: 100px;" <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cap."\""; ?> />
		</p>
	</div>
    <h3>Recapiti:</h3>
    <div>
        <p>
			<label for="tel">Telefono:</label>
			<input type="text" id="tel" name="tel"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->tel."\""; ?> />
		</p>
		<p>
			<label for="email">Email: </label>
			<input type="text" id="email" name="email" style="text-transform: none;"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->email."\""; ?> />
		</p>
		<p>
			<label for="cell_p">Cellulare personale:</label>
			<input type="text" id="cell_p" name="cell_p"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cell_personal."\""; ?> />
		</p>
		<p>
			<label for="cell_g">Cellulare genitore:</label>
			<input type="text" id="cell_g" name="cell_g"  <?php if(isset($result['edit'])) echo "value=\"".$result["edit"]->cell_parent."\""; ?> />
		</p>
	</div>
</div>
<div style="clear:both; text-align:center; padding: 15px;">
	<input type="hidden" name="operation" value="<?php echo 'editChanges#'.$result["edit"]->id ?>" />
	<div class="button">
		<button type="submit">Salva Modifiche</button>
		<button type="button" onclick="abort();">Annulla Modifiche</button>
	</div>
</div>
</form>
            