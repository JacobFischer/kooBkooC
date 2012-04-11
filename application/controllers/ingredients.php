<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingredients extends CI_Controller //display ingredients by id
{
	public function index()
	{
		 $query  = $this->db->query("SELECT ID, COUNT(IngredientsID) as freq , Name FROM RecipesIngredients JOIN Ingredients on Ingredients.ID = RecipesIngredients.IngredientsID GROUP BY IngredientsID DESC");

		 $total = 0;
               // $max_font_size = 600;

                foreach($query->result() as $i)
                {
                        $total = $total + $i->freq;
                }
		
		$max_font_size = $total * 10;
		if($query->num_rows() == 0)
                {
                        $this->template->load('error', array('title' => 'No tags found' , "message" => "did not work"));//load error view

                }
                else
                {
                        $this->template->load('ingredients_cloud_view' , array("ingredient" => $query  , "total" => $total, "max_font" => $max_font_size ));
                }
        }



  public function id($id)
  {
    //create a query
    $this->db->select('*');
    $this->db->from('Ingredients');
    $this->db->where('ID',$id);  
    $query = $this->db->get();   //run query to retrieve the information required for view

    if($query->num_rows() != 1)
    {
      $this->template->load('error', array("Ingredient" => "Ingredient with ID of \"$id\"not found" ));//load error view  
    }
    else
    {
      $this->template->load('ingredients_id',array("ingredient" => $query->row(0) ));	//load view of the ingredient and pas in params
    }             
  }
	
               
	
		
	

	//return ingredient view for a supplied recipeid
	public function recipes($id)
	{
		$query = $this->db->query("SELECT * FROM RecipesIngredients JOIN Recipes on RecipesIngredients.RecipesID = Recipes.ID WHERE RecipesIngredients.IngredientsID = \"$id\" ");
	 
		if($query->num_rows() < 1)
		{
			$this->template->load('error', array('title' => 'No recipes found for this ingredient!', "message" => "The recipe with id  \"$id\" returned no ingredients") );//load error view
		}
		else
		{
			$this->template->load('ingredientsview', array("ingredient" => $query) );  //load view to display results
		}
	

	} 
}

 


