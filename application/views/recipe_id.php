<?php function displayComments($com)
{
  foreach($com as $c):
    
    foreach($com as $d):
    endforeach;
  endforeach;
}
?>

<div id="testDiv"></div>
<div id="recipeid"><?=$recipe->ID?></div>

<h1>Recipe: <?=$recipe->Description?></h1>
<br/>
You'll need:<br/>
<? foreach( $ingredients as $ingredient):?>
<?=$ingredient->Name?><br/>
<?php endforeach;?><br/>
<p>Directions:<br/><?=$recipe->Directions?></p><br/>
Total Rating: <?=$vote_count->Direction?><br/><br/>
<button id="buttonUp">Up! ^</button>
<button id="buttonDown">Down! v</button><br/>
Tags:
<? foreach( $tags as $tag):?>
<?$j = $tag->ID?>
<a href="<?=base_url() . "index.php/tags/recipes/$j"?>"><?=$tag->Name?></a>
<?php endforeach;?><br/>

Comments:<br/>
<?php displayComments($comments)?>

<?php foreach( $comments as $comment ): ?>
<?=$comment->DisplayName?> 
Date: 
<?=$comment->Time?> <br/>
<?=$comment->Text?><br/><br/>
<?php endforeach; ?>

Post Comment:
<textarea id="postcomment" style="height: 100px; width: 500px"></textarea>
<button id="comment_button"> Post! </button>
<marquee> Made by Tim!</marquee> by Tim!</marquee>