<h1>Add an Ingredient</h1>
<div id="ingredients-add-wrapper">
  <form action="<?=site_url( array('ingredients', 'submit' ) ) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="ingredients-add">
    <label for="ingredients-name">Name</label>
    <input id="ingredients-name" name="ingredient" type = "text"/>
    <br/>
    
    <div id="testDiv"></div>
    <label for="ingredients-description">Description</label>
    <input name="description" type="text" id="ingredients-description"/>
    <br/>
    
    <label for="ingredients-base-unit">Base unit of measurement</label>
    <input name="measurement" type="text" id="ingredients-base-unit"/>
    <br/>
    
    <label for="ingredients-image">Image of the ingredient (must be a JPG)</label>
    <input type="file" name="userfile" id="ingredients-image"/>
    <br/>
    
    <input name="submit_button" type="submit" value="Submit Ingredient!"/>
  </form>
  <div id="suggested-ingredients">
    <h2>Is your Ingredient already added?</h2>
    <section id="guessed-ingredients">
    </section>
  </div>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;