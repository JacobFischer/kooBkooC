<h1>Add an Ingredient</h1>
<form action="<?=base_url() . "index.php/ingredients/submit/"?>" method="post">
  Name: <input name="ingredient" type = "text"/> <span id="guesser">Guess Ingredient</span><br/>
  Description: <input name="description" type = "text"/><br/>
  Base unit if measurement: <input name="measurement" type="text"/><br/>
  Image: <br/>
  <input name="submit_button" type="submit" value="Submit Ingredient!"/>
</form>
<marquee>Made by Tim!!!</marquee>