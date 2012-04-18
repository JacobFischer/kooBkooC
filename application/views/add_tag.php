<h1>Add a Tag!</h1>
<form action="<?=base_url() . "index.php/tags/submit/"?>" method="post">
  Name: <input id = "tag-name" name="tag_name" type = "text"/><span id="guesser-tag">Guess Tag</span><br/>
  <div id="testDiv"></div>
  Description: <input name="description" type = "text"/><br/>
  <input name="submit_button" type="submit" value="Submit Tag!"/>
</form>
<marquee>Made by Tim!!!</marquee>