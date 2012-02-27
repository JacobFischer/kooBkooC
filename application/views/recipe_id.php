<script type = "text/javascript">
function voteup()
{
 <?
    
 ?>
}

function votedown()
{
}
</script>

<h1>Recipe: <?=$recipe->Description?></h1>
<br/>
<p><?=$recipe->Directions?></p><br/>
Total Rating: <?=$vote_count->Direction?><br/><br/>
<button onclick="voteup()">Up! ^</button>
<button onclick="votedown()">Down! v</button><br/>
Comments:</br>
<?php foreach( $comments as $comment ): ?>
<?=$comment->DisplayName?> 
<?=$comment->Time?> <br/>
<?=$comment->Text?><br/><br/>
<?php endforeach; ?>
<marquee> Made by Tim!</marquee>