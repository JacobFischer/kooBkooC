<?php foreach ( $recipes as $recipe ): ?>
<?=$this->load->view('recipes/short', array('recipe' => $recipe, 'reverse' => true ) )?>
<?php endforeach; ?>