<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingredient extends CI_Controller{       //display ingredients by id
	public function id($id)
	{	
		//create a query
		this->db->SELECT('*');
                this->db->FROM('Ingredients');
		this->db->WHERE('ID',$id);  
                $query = this->db->get();   //run query to retrieve the information required for view

		if($query->num_rows() != 1)
                {
                	$this->template->load('error', array("Ingredient" =>"Ingredient with ID of \"$id\"not found" ));//load error view  
		}
		else
		{
			$this->template->load('ingredients_id',array("ingredient"=>$query->row(0));	//load view of the ingredient and pas in params
		}
               
	
		
	}

	//return ingredient view for a supplied recipeid
	public function recipe($recipeid)
	{
		$query = $this->db->query("SELECT * FROM RecipesIngredients JOIN Ingredients on RecipesIngredients.IngredientsID = Ingredients.ID WHERE \"$recipeid\" = RecipeIngredients.RecipesID");
	
		if($query->num_rows() < 1)
		{
			$this->template->load('error', array('title' => 'Ingredients not found!', "message" => "The recipe with id  \"$recipeid\" returned no ingredients") );//load error view
		}
		else
		{
			$this->load->view('ingredientsview', array("ingredients" => $query);  //load view to display results
		}
	

	} 
		
		

}


