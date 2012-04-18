<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingredients extends CI_Controller //display ingredients by id
{

	public function index()
	{
    $this->template->load_js("jquery.masonry.min.js");
    $this->template->load_js("ingredients_cloud.js");
    $query  = $this->db->query("SELECT ID, COUNT(IngredientsID) as freq , Name FROM RecipesIngredients JOIN Ingredients on Ingredients.ID = RecipesIngredients.IngredientsID GROUP BY IngredientsID DESC");

    $total = 0;

     foreach($query->result() as $i)
    {
      $total = $total + $i->freq;
    }
		
		$max_font_size = $total * 10;
		//$max_font_size = 700;		
	if($query->num_rows() == 0)
    	{
      		$this->template->load('error', array('title' => 'No tags found' , "message" => "did not work"));//load error view
    	}
    else
    {
      $this->template->load('ingredients_cloud_view' , array("ingredients" => $query->result()  , "total" => $total, "max_font" => $max_font_size ));
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
      $this->db->flush_cache(); 
      $usingQuery = $this->db->query("SELECT * FROM RecipesIngredients JOIN Recipes on RecipesIngredients.RecipesID = Recipes.ID WHERE RecipesIngredients.IngredientsID = \"$id\" ");
      
      $this->template->load( 'ingredients_id',array("ingredient" => $query->row(0), "recipes" => $usingQuery ->result() )); //load view of the ingredient and pas in params
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
      $this->template->load('error',array('title'=>'ingredient already exists', "message"=>"The ingredient is already in the database"));
      return;
    }
    
    if(!($this->db->insert("Ingredients", $data)) )
    {
      $this->template->load('error', array('title' => 'Could not add ingredient.' , "message" => "Error in creating ingredient."));
      return;
    }
    else
    {
      $query = $this->db->query("SELECT * FROM Ingredients WHERE Name = '$name'");
      if( $query->num_rows() != 1 )
      {
        $this->template->load('error', array('title' => 'Could not find added ingredient.' , "message" => "Error in creating ingredient."));
        return;
      }
      
      $ingredientID = $query->row(0)->ID;

      $config['upload_path'] = '../../cs397_uploads/ingredients/';
      $config['allowed_types'] = 'jpg';
      $config['max_size'] = '1000';
      $config['max_width'] = '2048';
      $config['max_height'] = '1024';
      $config['file_name']  = $ingredientID . ".jpg";
      $this->load->library('upload', $config);
      
      // Get the Image they uploaded
      if ( ! $this->upload->do_upload())
      {
        // Delete the added ingredient as they didn't have an image
        $this->db->where('ID', $ingredientID);
        $this->db->delete('Ingredients'); 

        $this->template->load('error' , array('title' => 'Image Upload Error' , "message" => "There was an error uploading your image: <br/>" . $this->upload->display_errors()));
        return;
      }
      else
      {
        //print $this->upload->data();
      }
      
      $this->template->load('ingredient_success', array("name" =>$name));
    }
  }
  
}

 


