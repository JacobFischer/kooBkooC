<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Programmer: Michael Wilson
//Ingredients controller
//This will handle all the views for ingredients
class Ingredients extends CI_Controller //display ingredients by id
{

  //Programmers: Michael Wilson and Jacob Fischer
  
  public function index()
  {
    $this->template->set_location("Ingredients");
    $this->template->set_title("Top");
    
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
      $this->template->load('ingredients/cloud' , array("ingredients" => $query->result()  , "total" => $total, "max_font" => $max_font_size ));
    }
  }

//This will take a ingredient id and take you to thtat ingredients page
  public function id($id)
  {
    $this->template->set_location("Ingredients");
    $this->template->set_title("ID Error");
    //create a query
    $this->db->select('*');
    $this->db->from('Ingredients');
    $this->db->where('ID',$id);  
    $query = $this->db->get();   //run query to retrieve the information required for view

    if($query->num_rows() != 1)
    {
      $this->template->load('error', array("Ingredient" => "Ingredient with ID of \"$id\"not found" ));
      return;      
    }
    
    $ingredient = $query->row(0);
    
    $this->db->flush_cache(); 
    //$usingQuery = $this->db->query("SELECT * FROM RecipesIngredients JOIN Recipes on RecipesIngredients.RecipesID = Recipes.ID WHERE RecipesIngredients.IngredientsID = \"$id\" ");
    /////
    $usingQuery = $this->db->query("SELECT Votes.RecipesID AS ID, SUM(Direction) AS Direction, Name, Description FROM Votes JOIN Recipes on Votes.RecipesID = Recipes.ID JOIN RecipesIngredients on RecipesIngredients.RecipesID = Recipes.ID WHERE RecipesIngredients.IngredientsID = \"$id\" GROUP BY Recipes.ID ORDER BY SUM(Direction) DESC" ); 
    $recipes = $usingQuery->result();
    
    if($query->num_rows() == 0)
    {
      $this->template->load('error', array('title' => 'No recipes found for Tag ' . $tagQuery->row(0)->Name , "message" => "Sorry, maybe you should create some recipes that use it?")); // load error view
      return;
    }
    
    $userID = -1;
    if($this->session->userdata('logged_in'))
    {
      $this->db->select('*');
      $this->db->from('Users');
      $this->db->where('Email', $this->session->userdata('email'));
      $query = $this->db->get();
      
      if($query->num_rows() != 1)
      {
        $this->template->load('error' , array('title' => 'Error: Cookie Error' , "message" => "You are logged in, but we can not find you") );
        return;
      }
      
      $userID = $query->row(0)->ID;
    }
    
    foreach($recipes as $recipe)
    {
      $recipe->UsersVote = "0";
      if( $userID != -1 )
      {
        $this->db->select('*');
        $this->db->from('Votes');
        $this->db->where('UsersID', $userID );
        $this->db->where('RecipesID', $recipe->ID );
        $query = $this->db->get();
        
        if($query->num_rows() == 1)
        {
          $recipe->UsersVote = $query->row(0)->Direction;
        }
      }
    }
    /////
    $this->template->set_title( $ingredient->Name );
    $this->template->load( 'ingredients/id', array("ingredient" => $ingredient, "recipes" => $recipes )); //load view of the ingredient and pas in params           
  }

  //recipes function: Takes in ingredient id and return the recipes that use the ingredient. 
  public function recipes($id)
  {
    $query = $this->db->query("SELECT * FROM RecipesIngredients JOIN Recipes on RecipesIngredients.RecipesID = Recipes.ID WHERE RecipesIngredients.IngredientsID = \"$id\" "); //query that returns all recipes corresponding to the ingredient id passed into this function 
   
    if($query->num_rows() < 1) // error case
    {
      $this->template->load('error', array('title' => 'No recipes found for this ingredient!', "message" => "The recipe with id  \"$id\" returned no ingredients") );//load error view
    }
    else //load view
    {
      $this->template->load('ingredients/recipes', array("ingredient" => $query) );  //load view to display results
    }
  } 
  
  public function add()
  {
    $this->template->set_location("Ingredients");
    $this->template->set_title("Add");
    
    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
    {
      $this->template->load('error', array('title' => 'Not logged in.' , "message" => "You must be logged in to add an ingredient."));
      return;
    }
    $this->template->load_js("ingredients_add.js");
    $this->template->load_js("submit_guess.js");
    $this->template->load('add_ingredient' , array("recipe" => 0, "tag" => 0 ));
  }
  
  public function submit()
  {
    $name = $this->input->post("ingredient");
    $desc = $this->input->post("description");
    $measure = $this->input->post("measurement");
    if(!($this->input->post("ingredient")&&$this->input->post("description")&&$this->input->post("measurement")))
    {
      $this->template->load('error',array('title'=>'Missing Info',"message"=>"Please fill out the entire form!"));
      return;
    }

    $name = trim($name);
    $desc = trim($desc);
    $measure = trim($measure);
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
      
      $this->template->load('ingredient/success', array("name" =>$name));
    }
  }
  
}

 


