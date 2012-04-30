<!--This view created by Tim Pund-->
<h1>Add a Tag</h1>
<div id="tags-add-wrapper">
  <form action="<?=site_url( array('tags', 'submit' ) ) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="ingredients-add">
    <label for="tags-name">Name</label>
    <input id="tags-name" name="tag_name" type = "text"/>
    <br/>
    
    <label for="tags-description">Description</label>
    <input name="description" type="text" id="tags-description"/>
    <br/>
    
    <input name="submit_button" type="submit" value="Submit Tag"/>
  </form>
  <div id="suggested-tags">
    <h2>Is your Tag already added?</h2>
    <section id="guessed-tags">
    </section>
  </div>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;