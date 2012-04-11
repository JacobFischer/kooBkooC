<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller
{

  public function index()
  {
	$query = $this->db->query("SELECT RecipesID, SUM(Direction), Name FROM Votes JOIN Recipes on Votes.RecipesID = Recipes.ID GROUP BY RecipesID ORDER BY SUM(Direction) DESC LIMIT 5" ); 

	if($query->num_rows() == 0)
	{
		$this->template->load('error' , array('title' => 'No recipes found!' , "message" => "Sorry, no recipes were found :( ") );
    	}

	else
    	{
		$this->template->load('recipes_page' , array("recipes" => $query));
	}
  }
  
  public function submit()
  {
    //$this->template->load('error' , array('title' => 'Recipe Submitted!' , "message" => "Recipe has been successfully submitted ") );
    //Load all of the variables that should have been passed from the form
    $name = $this->input->post("recipeName");
    $description = $this->input->post("recipe-description");
    $directions = $this->input->post("recipe-directions");
    $ingredients = $this->input->post("ingredients");
    $tags = $this->input->post("tags");
    $servings = $this->input->post("servings");
    $ingredientAmounts = $this->input->post("ingredientAmount");
    
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
        $this->template->load('error' , array('title' => 'Invalid Measurement!' , "message" => "Please make sure all input ingredient ammounts are numeric "));
        return;
      }
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
       
    //Get the user's e-mail
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('Email', $this->session->userdata('email'));
    $query = $this->db->get();
    
    //Add all of the retreived information to an array to be passed when the recipes is added
    $recipeData = array('SubmitterUsersID' => $query->row(0)->ID, 'Name' => $name,'Directions' => $directions, 
      'Servings' => $servings, 'ImageURL' => 'NULL', 'Description' => $description);   
     
    //Inserting the information to the database
    if(!($this->db->insert("Recipes", $recipeData)) )
    {
      $this->template->load('error' , array('title' => 'Recipe Not Sumbitted!' , "message" => "One of the values you input are invalid!"));
      return;
    }
    else
    {
      $this->db->select('*');
      $this->db->from('Recipes');
      $this->db->where('Name', $name);
      $newRecipe = $this->db->get();

      //Constructing array for the recipe tag  
      foreach($tags as $tag)
      {      
        $tagData = array('RecipesID' => $newRecipe->row(0)->ID ,'TagsID' => $tag);
        if(!($this->db->insert("RecipesTags", $tagData)) )
        {
          $this->template->load('error' , array('title' => 'Tags Not Submitted!' , "message" => "UH OH! BAD THINGS HAPPENED"));
          return;
        }    
      }      
      //Adding all of the ingredients and their amounts to the database
      $index = 0;
      foreach($ingredients as $ingredient)
      {
        if ($ingredientAmounts[$index] > 0)
        {
          $ingredientData = array('RecipesID' => $newRecipe->row(0)->ID, 'IngredientsID' => $ingredient, 'Amount' =>$ingredientAmounts[$index]); 
          if(!($this->db->insert("RecipesIngredients", $ingredientData)) )
          {
            $this->template->load('error' , array('title' => 'Ingredient Not Submitted!' , "message" => "UH OH! BAD THINGS HAPPENED"));
            return;
          }
        }
        $index += 1;
      }
      
      redirect('recipe/id/' + $newRecipe->row(0)->ID, 'location', 301);
      
      return;
    }
  }
  
  public function id($id)
  {
    $this->template->load_js("recipe_id.js");
    
    // Build the SQL-ish query using CodeIgniters's Active Record to get the Cookware with the id passed in
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->where('ID', $id);
    $recipequery = $this->db->get();
    
    $recipeInfo = $recipequery->row(0);
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
      $this->template->load('recipe_id', array("recipe" => $recipeInfo ,
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
    $tagquery= $this->db->query("SELECT * FROM Tags");
    $ingredientsquery=$this->db->query("SELECT * FROM Ingredients");       
    $this->template->load_js("recipe_add.js");
    $this->template->load( 'recipe_add', array("tags" => $tagquery->result(),
                                        "ingredients" => $ingredientsquery->result()));
  }
  
  
  
  /*
  public function add($name, $tag, $ingredients)
  {
    $r = array( "json" => array() );
    $r["json"]["success"] = false;
    
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->where('ID', $recipeID);
    $query = $this->db->get();
    
    if($query->num_rows() != 1)
    {
      $r["json"]["reason"] = "The recipe you voted could not be found.";
      $this->load->view('json', $r);
      return;
    }
    
    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
    {
      $r["json"]["reason"] = "You must be logged in to comment.";
      $this->load->view('json', $r);
      return;
    }

    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('Email', $this->session->userdata('email'));
    $query = $this->db->get();
    
    if($query->num_rows() != 1)
    {
      $r["json"]["reason"] = "There is an error in your current session, try clearing your cookies for kooBkooC.net";
      $this->load->view('json', $r);
      return;
    }
    
    $contents = urldecode($contents);
    $data = array('UsersID'=> $query->row(0)->ID, 'RecipesID' => $recipeID, 'Text' => $contents, 'Time' => date( 'Y-m-d H:i:s') );
    
    if(!($this->db->insert("Comments", $data)) )
    {
      $r["json"]["reason"] = "There was an error ading your comment to our database.";
      $this->load->view('json', $r);
      return;
    }
    else
    {
      $comment->DisplayName = $query->row(0)->DisplayName;
      $comment->Time = date( 'Y-m-d H:i:s');
      $comment->Text = $contents;
      $r["json"]["success"] = true;
      $r["json"]["newHTML"] = base64_encode($this->load->view('recipe_comment', array('comment' => $comment, "hide" => true ), true ));
      $this->load->view('json', $r);
      return;
    }
  }*/
}

/* End of file recipe.php */
/* Location: ./application/controllers/recipe.php */

