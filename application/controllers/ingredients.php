<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingredients extends CI_Controller //display ingredients by id
{
  public function index()
  {
    $query = $this->db->query("SELECT * FROM Ingredients");
    
    if($query->num_rows() <1)
    {
      $this->template->load('error', array("Ingredient" => "Ingredient with ID of \"$id\"not found" ));//load error view  
    }
    $this->template->load('ingredients_id',array("ingredient" => $query ));	//load view of the ingredient and pas in params
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
      $this->template->load('ingredients_id',array("ingredient" => $query));	//load view of the ingredient and pas in params
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
  
  public function add()
  {
    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
    {
      $this->template->load('error', array('title' => 'Not logged in.' , "message" => "You must be logged in to add an ingredient."));
      return;
    }
    $this->template->load_js("submit_guess.js");
    $this->template->load('add_ingredient' , array("recipe" => 0, "tag" => 0 ));
  }
  
    public function submit()
  {
    $name = $this->input->post("ingredient");
    $desc = $this->input->post("description");
    $measure = $this->input->post("measurement");
    
    $data = array('Name' => $name,'BaseUnitOfMeasure'=>$measure,'Description' =>$desc);
    $query = $this->db->query("SELECT * FROM Ingredients WHERE Name = '$name'");
    if($query->num_rows()>0)
    {
      $this->template->load('error',array('title'=>'Tag already exists', "message"=>"The tag is already in the database"));
      return;
    }
    if(!($this->db->insert("Ingredients", $data)) )
    {
      $this->template->load('error', array('title' => 'Could not add tag.' , "message" => "Error in creating tag."));
      return;
    }
    else
    {
      $this->template->load('ingredient_success',array("name" =>$name));
    }
  }
}

 


