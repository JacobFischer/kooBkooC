<h1>Add an Ingredient</h1>
<form action="<?=base_url() . "index.php/ingredients/submit/"?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  Name: <input id="ingredients-name" name="ingredient" type = "text"/> <span id="guesser">Guess Ingredient</span><br/>
  <div id="testDiv"></div>
  Description: <input name="description" type = "text"/><br/>
  Base unit if measurement: <input name="measurement" type="text"/><br/>
  <h2>Image of the ingredient (must be a JPG)</h2>
	<input type="file" name="userfile" size="20" /><br/>
  <input name="submit_button" type="submit" value="Submit Ingredient!"/>
</form>