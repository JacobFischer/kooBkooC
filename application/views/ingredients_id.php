<h1>Ingredients</h1>

<a href="<?=base_url() . "index.php/ingredients/add"?>">Add an Ingredient!</a>
<ul>
   <?foreach ($ingredient->result() as $i):?>
   <br/>
   <li>Ingredient: <?=$i->Name?></li>
    <li>ID: <?=$i->ID?></li>
    <li>Description: <?=$i->Description?></li>
    <li>Base Unit of Measure:<?=$i->BaseUnitOfMeasure?></li>
    <li>ImageURL: <?=$i->ImageURL?></li>
    <br/>
    <?endforeach;?>
   
     
</ul>

