<form  name="formPost" action="" method="POST" onsubmit="return verifForm()">
	<div class="row">	
		<div class="form-group col-lg-8 col-md-8">
			<h4>Modifier :</h4>
			<textarea class="form-control"  id="idtexte" name="texte" rows="4" cols="50" maxlength="1000" title="Description de la catégorie"><?php if (isset($post['Texte'])) echo $post['Texte'] ?></textarea><br>
		</div>
	</div>
	<input class="btn btn-default" type="submit" value="Valider">
	<input class="btn btn-default" type="reset" value="Reinitialiser"/> 
</form>	