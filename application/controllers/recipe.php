<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller
{
  //programmer: Michael Wilson and Company  //function: index.   This will show top rated recipes
  public function index()
  {
    $this->page(1);
  }
  
  public function page($paging)
  {
    $limit = 5;
    $offset = ($paging-1)*$limit;
    $totalRecipes = (int)$this->db->query( "SELECT COUNT(*) AS TotalCount FROM Recipes" )->row(0)->TotalCount;
    
    if($paging <= 0 || (int)($totalRecipes/$limit)+1 < $paging )
    {
      $this->template->load('error' , array('title' => 'Error: Page out of range' , "message" => "There can't exits any recipes for the given page") );
      return;
    }
    
    $page = (object)array();
    $page->Current = $paging;
    $page->Start = $offset+1;
    $page->Previous = $paging != 1;
    $page->Next = $paging*$limit <= $totalRecipes;
    
    // Load JS files in the template
    $this->template->load_js('recipe_voter.js');
    $this->template->load_js('ingredients_index.js');
    
    $this->template->set_location("Recipes");
    $this->template->set_title("Top");
    
   //Query to find top rated recipes and return them in descending order
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
    
    $query = $this->db->query("SELECT RecipesID AS ID, SUM(Direction) AS Direction, Name, Description FROM Votes JOIN Recipes on Votes.RecipesID = Recipes.ID GROUP BY RecipesID ORDER BY SUM(Direction) DESC LIMIT $limit OFFSET $offset" ); 
    $recipes = $query->result();
    
    if($query->num_rows() == 0) //error case
    {
      $this->template->load('error' , array('title' => 'No recipes found!' , "message" => "Sorry, no recipes were found :( ") );
      return;
    }
    
    foreach($recipes as $recipe)
    {
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
        else
        {
          $recipe->UsersVote = "0";
        }
      }
      else
      {
        $recipe->UsersVote = "0";
      }
    }

    $this->template->load('recipes/index' , array("recipes" => $recipes, 'page' => $page ) );
  }
  
  public function submit()
  {  
    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
    {
      $this->template->load('error' , array('title' => 'Please Login or Sign Up!' , "message" => "You must be logged in to submit a recipe!"));
      return;
    }
    $this->template->load_js("recipe_add.js");
    $name = $this->input->post("recipeName");
    $description = $this->input->post("recipe-description");
    $directions = $this->input->post("recipe-directions");
    $ingredients = $this->input->post("ingredients");
    $tags = $this->input->post("tags");
    $servings = $this->input->post("servings");
    $ingredientAmounts = $this->input->post("ingredientAmounts");
    //Load all of the variables that should have been passed from the form
    if(strlen($name) < 3)
    {
      $this->template->load('error' , array('title' => 'Invalid Name!' , "message" => "Your recipe's name must be longer than that!"));
      return;
    }
    if(strlen($directions) < 30)
    {
      $this->template->load('error' , array('title' => 'Insufficient Directions!' , "message" => "Your recipe must contain more descriptive directions!"));
      return;
    }
    if(strlen($description) < 10)
    {
      $this->template->load('error' , array('title' => 'Insufficient Description!' , "message" => "You must enter more words because we said so!"));
      return;
    }
    if(empty($ingredients))
    {
      $this->template->load('error' , array('title' => 'No Ingredients!' , "message" => "A recipe requires ingredients!"));
      return;
    }
    if(empty($tags))
    {
      $this->template->load('error' , array('title' => 'No Tag!' , "message" => "A recipe requires at least one tag!"));
      return;
    }
    if(empty($ingredientAmounts))
    {
      $this->template->load('error' , array('title' => 'How did you get here?!' , "message" => "You shouldn't even be able to reach this page!"));
      return;
    }
    
    //Removes the 0 value ingredients form the list
    $index = 0;
    foreach($ingredients as $ingredient)
    {
      if ($ingredientAmounts[$index] == 0 or $ingredient == "")
      {
        unset($ingredients[$index]);
      }
      $index += 1;
    }   
   
    $index = 0;
    foreach($tags as $tag)
    {
      if($tag == "")
      {
        unset($tags[$index]);
      }
      $index += 1;
    }
    
      
    //Checks that all input amounts are numeric
    foreach($ingredientAmounts as $amount)
    {
      if(is_numeric($amount) == False)
      {
        $this->template->load('error' , array('title' => 'Invalid Measurement!' , "message" => "Please make sure all input ingredient amounts are numeric "));
        return;
      }
    }
    
    if(is_numeric($servings) == False)
    {
      $this->template->load('error' , array('title' => 'Invalid Serving!' , "message" => "Please make sure you amount is numeric "));
        return;
    }
       
    //Checks to see that the name of the recipe is still available
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->where('Name', $name );
    $nameCheckQuery = $this->db->get();
    if($nameCheckQuery->num_rows() > 0)
    {
      $this->template->load('error' , array('title' => 'Recipe Already Exists!' , "message" => "This recipe already exists in the system!"));
      return;
    }
    
    //Make sure the recipe has at least 2 
    if(sizeof($ingredients) < 2)
    {
      $this->template->load('error' , array('title' => 'Not Enough Ingredients!' , "message" => "You need more ingredients for this is be a recipe...come on now!"));
      return;
    }
    
    //Makes sure the submitted recipe has a name
    if(!$name)
    {
      $this->template->load('error' , array('title' => 'Your Recipe Needs a Name!' , "message" => "Please enter a name for the recipe"));
      return;
    }
    
    //Makes sure there are no duplicate ingredients
    if(count(array_unique($ingredients))<count($ingredients))
    { 
      $this->template->load('error' , array('title' => 'Duplicate Ingredient!' , "message" => "You may not include the same ingredient more than once in a recipe "));
      return;
    }
    
    //Makes sure all selected tags are unique
    if(count(array_unique($tags))<count($tags))
    { 
      $this->template->load('error' , array('title' => 'Duplicate Tag!' , "message" => "You may not include the same tag more than once in a recipe "));
      return;
    }
    
    //Finding the submitter's user ID
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('Email', $this->session->userdata('email'));
    $userQuery = $this->db->get();
    $userID = $userQuery->row(0)->ID;
    
    //Add all of the retreived information to an array to be passed when the recipes is added
    $recipeData = array('SubmitterUsersID' => $userID, 'Name' => $name,'Directions' => $directions, 
      'Servings' => $servings, 'ImageURL' => 'NULL', 'Description' => $description);   
     
    //Inserting the information to the database
    if(!($this->db->insert("Recipes", $recipeData)) )
    {
      $this->template->load('error' , array('title' => 'Recipe Not Sumbitted!' , "message" => "One of the values you input are invalid!"));
      return;
    }
    
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->where('Name', $name);
    $newRecipe = $this->db->get();
    $recipeID = $newRecipe->row(0)->ID;
    
    $config['upload_path'] = '../../cs397_uploads/recipes/';
    $config['allowed_types'] = 'jpg';
    $config['max_size'] = '1000';
    $config['max_width'] = '2048';
    $config['max_height'] = '1024';
    $config['file_name']  = $recipeID . ".jpg";
    $this->load->library('upload', $config);
    
    // Get the Image they uploaded
    if ( ! $this->upload->do_upload() )
    {
      // Delete the added ingredient as they didn't have an image
      $this->db->where('ID', $recipeID);
      $this->db->delete('Recipes'); 
      
      $this->template->load('error' , array('title' => 'Image Upload Error' , "message" => "There was an error uploading your image: <br/>" . $this->upload->display_errors()));
      return;
    }
    
    //Constructing array for the recipe tag  
    foreach($tags as $tag)
    {      
      $tagData = array('RecipesID' => $recipeID ,'TagsID' => $tag);
      if(!($this->db->insert("RecipesTags", $tagData)) )
      {
        $this->template->load('error' , array('title' => 'Tags Not Submitted!' , "message" => "There was an error adding your Recipe's tag to the database"));
        return;
      }    
    }      
    //Adding all of the ingredients and their amounts to the database
    $index = 0;
    foreach($ingredients as $ingredient)
    {
      if ($ingredientAmounts[$index] > 0)
      {
        $ingredientData = array('RecipesID' => $recipeID, 'IngredientsID' => $ingredient, 'Amount' =>$ingredientAmounts[$index]); 
        if(!($this->db->insert("RecipesIngredients", $ingredientData)) )
        {
          $this->template->load('error' , array('title' => 'Ingredient Not Submitted!' , "message" => "There was an error adding your Recipe's ingredients to the database"));
          return;
        }
      }
      $index += 1;
    }
    
    
    
    //Upvoting your recipe
    $voteData = array('UsersID' => $userID, 'RecipesID' => $recipeID, 'Direction' => 1); 
    if(!($this->db->insert("Votes", $voteData)) )
    {
      $this->template->load('error' , array('title' => 'Vote Not Submitted!' , "message" => "There was an error automatically upvoting your recipe."));
      return;
    }
    
    redirect('recipes/id/'.$recipeID, 'location', 301);
  }
  
  public function id($id)
  {
    // Load JS files in the template
    $this->template->load_js("recipe_voter.js");
    $this->template->load_js("recipe_id.js");
    $this->template->set_location("Recipes");
    $this->template->set_title("Error");
    
    // Build the SQL-ish query using CodeIgniters's Active Record to get the Cookware with the id passed in
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->where('ID', $id);
    $recipequery = $this->db->get();
    
    if( $recipequery->num_rows() != 1 )
    {
      $this->template->load('error', array('title' => 'Recipe Not Found!', "message" => "The Recipe with id \"$id\" could not be found!") );
      return;
    }
    
    $recipeInfo = $recipequery->row(0);
    $this->template->set_title( $recipeInfo->Name );
    
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('ID', $recipeInfo->SubmitterUsersID);
    $submitterInfo = $this->db->get()->row(0);
    
    $recipeInfo->Directions = $this->textile->TextileThis( $recipeInfo->Directions );

    $this->db->select('*');
    $this->db->from('Votes');
    $this->db->where('RecipesID', $id);
    $this->db->select_sum('Direction');
    $votequery = $this->db->get();
    
    $this->db->select('*');
    $this->db->from('Comments');
    $this->db->join('Users','Users.ID = Comments.UsersID');
    $this->db->where('RecipesID', $id);
    $commentquery= $this->db->get();
    
    $comments = array();
    foreach( $commentquery->result() as $comment)
    {
      $comment->Text = $this->textile->TextileThis( $comment->Text );
      $comments[] = $comment;
    }
    
    // If the user is logged in
    $foundUserVote = false;
    if( $this->session->userdata('logged_in') )
    {
      $this->db->select('*');
      $this->db->from('Users');
      $this->db->where('Email', $this->session->userdata('email'));
      
      $userQuery = $this->db->get();

      if($userQuery->num_rows() == 1)
      {
        $userID = $userQuery->row(0)->ID;
        
        $this->db->select('*');
        $this->db->from('Votes');
        $this->db->where('RecipesID', $id);
        $this->db->where('UsersID', $userID);
        $userVoteQuery = $this->db->get();
        $foundUserVote = $userVoteQuery->num_rows() == 1;
      }
    }
    
    $userVoteInfo = array( "Direction" => 0 );
    if( $foundUserVote )
    {
      $userVoteInfo["Direction"] = $userVoteQuery->row(0)->Direction;
    }
    
    $tagquery= $this->db->query("SELECT *
                                FROM Tags
                                JOIN RecipesTags ON Tags.ID = RecipesTags.TagsID
                                WHERE RecipesID=\"$id\"");
                                                
    $ingredientsquery=$this->db->query("SELECT *
                                       FROM Ingredients
                                       JOIN RecipesIngredients ON Ingredients.ID = RecipesIngredients.IngredientsID
                                       WHERE RecipesID = \"$id\"");
    
    if($recipequery->num_rows() != 1)
    {
      $this->template->load('error', array('title' => 'Recipe Not Found!', "message" => "The Recipe with id \"$id\" could not be found!") );
    }
    else
    {      
      $this->template->load('recipes/id', array("recipe" => $recipeInfo ,
                                               "submitter" => $submitterInfo,
                                               "vote_count" => $votequery->row(0),
                                               "comments" => $comments,
                                               "tags" => $tagquery->result() ,
                                               "ingredients" => $ingredientsquery->result(),
                                               "users_vote" => $userVoteInfo
                                               )
                           );
    }
  }
  
  public function add()
  {
    $this->template->set_location("Recipes");
    $this->template->set_title("Add");
    
    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
    {
      $this->template->load('error' , array('title' => 'Please Login or Sign Up!' , "message" => "You must be logged in to submit a recipe!"));
      return;
    }
    
    $tagquery= $this->db->query("SELECT * FROM Tags");
    $ingredientsquery=$this->db->query("SELECT * FROM Ingredients");       
    $this->template->load_js("recipe_add.js");
    $this->template->load_js("submit_guess.js");
    $this->template->load( 'recipes/add', array("tags" => $tagquery->result(),
                                        "ingredients" => $ingredientsquery->result()));
  }
}

/* End of file recipe.php */
/* Location: ./application/controllers/recipe.php */

