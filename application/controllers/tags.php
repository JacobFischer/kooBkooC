<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {
	//Programmer: Michael Wilson
	//function index
	public function index()
	{
    		$this->template->load_js("jquery.masonry.min.js");
    		$this->template->load_js("tags_cloud.js");
		//SQL query to find tags, count up how many recipes use each one, and return an array of objects composed of TagName, TagID a,a dn the numbrt of times it is used
		$query	= $this->db->query("SELECT ID, COUNT(TagsID) as freq , Name FROM RecipesTags JOIN Tags on Tags.ID = RecipesTags.TagsID GROUP BY TagsID DESC");    	

		$total = 0; // this will hold the total number of recipes 
		$max_font_size = 200; //this will be the max value for the size of the tag images (will be sent to the tag_viw)

		foreach($query->result() as $i) //calculate the total number of time any tag appears in all recipes
		{
			$total = $total + $i->freq;
		}
	
		if($query->num_rows() == 0) //error case
		{
			$this->template->load('error', array('title' => 'No tags found' , "message" => "did not work"));//load error view  
		}
		else //load the tag view and pass it query results
		{
			$this->template->load('tag_view' , array("tags" => $query->result()  , "total" => $total, "max_font" => $max_font_size ));
		}
	}
	//Michael Wilson   function : Recipes 
	public function recipes($id)
	{
    // Load JS files in the template
    $this->template->load_js('recipe_voter.js');
    $this->template->load_js('ingredients_index.js');
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
    
    $query = $this->db->query("SELECT Votes.RecipesID AS ID, SUM(Direction) AS Direction, Name, Description FROM Votes JOIN Recipes on Votes.RecipesID = Recipes.ID JOIN RecipesTags on RecipesTags.RecipesID = Recipes.ID WHERE RecipesTags.TagsID = \"$id\" GROUP BY Recipes.ID ORDER BY SUM(Direction) DESC" ); 
    $recipes = $query->result();
    
    if( $userID != -1 )
    {
      foreach($recipes as $recipe)
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
    }
    // OLD OLD OLD OLD
		//$query = $this->db->query("SELECT * FROM RecipesTags JOIN Recipes on RecipesTags.RecipesID = Recipes.ID WHERE RecipesTags.TagsID = \"$id\" ");
		//query to return tag corresponding to tag id
	  $this->db->select('*');
    $this->db->from('Tags');
    $this->db->where('ID', $id);

	  $tagQuery = $this->db->get(); //run the query


		if($query->num_rows() == 0)
		{
      			$this->template->load('error', array('title' => 'No recipes found' , "message" => "did not work"));//load error view
    		}
		else
    		{
      			$this->template->load('tags/recipes' , array("recipes" => $recipes, "tag" => $tagQuery->row(0) ));
    		}
	}

	public function add()
  {	
    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
    {
      $this->template->load('error', array('title' => 'Not logged in.' , "message" => "You must be logged in to add a tag."));
      return;
    }
    $this->template->load_js("submit_guess.js");
    $this->template->load('add_tag' , array("recipe" => 0, "tag" => 0 ));
  }
  
	public function submit()
  {
    $name = $this->input->post("tag_name");
    $desc = $this->input->post("description");
    if(!($this->input->post("tag_name")&&$this->input->post("description")))
    {
      $this->template->load('error',array('title'=>'Missing Info',"message"=>"Please fill out the entire form!"));
      return;
    }
    $name = trim($name);
    $desc = trim($desc);
    $data = array('Name' => $name,'Description' =>$desc);
    $query = $this->db->query("SELECT * FROM Tags WHERE Name = '$name'");
    		
		if($query->num_rows()>0)
    {
			$this->template->load('error',array('title'=>'Tag already exists', "message"=>"The tag is already in the database"));
			return;
    }
    
		if(!($this->db->insert("Tags", $data)) )
    {
      $this->template->load('error', array('title' => 'Could not add tag.' , "message" => "Error in creating tag."));
      return;
    }
    		
		else
    {
      $this->template->load('tag_success',array("name" =>$name));
		}
	}

}

		
	
