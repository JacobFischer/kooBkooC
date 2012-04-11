<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {
	public function index()
	{
		$query	= $this->db->query("SELECT ID, COUNT(TagsID) as freq , Name FROM RecipesTags JOIN Tags on Tags.ID = RecipesTags.TagsID GROUP BY TagsID DESC");   	

		$total = 0;
		$max_font_size = 200;

		foreach($query->result() as $i)
		{
			$total = $total + $i->freq;
		}
	
		if($query->num_rows() == 0)
		{
			$this->template->load('error', array('title' => 'No tags found' , "message" => "did not work"));//load error view  
			
		}
		else
		{
			$this->template->load('tag_view' , array("tag" => $query  , "total" => $total, "max_font" => $max_font_size ));
		}
	}

	public function recipes($id)
	{
	  $query = $this->db->query("SELECT * FROM RecipesTags JOIN Recipes on RecipesTags.RecipesID = Recipes.ID WHERE RecipesTags.TagsID = \"$id\" ");
	
	  $this->db->select('*');
    $this->db->from('Tags');
    $this->db->where('ID', $id);

	  $tagQuery = $this->db->get();

		if($query->num_rows() == 0)
    {
      $this->template->load('error', array('title' => 'No recipes found' , "message" => "did not work"));//load error view
    }
    else
    {
      $this->template->load('recipe_list' , array("recipe" => $query, "tag" => $tagQuery->row(0) ));
    }
	}

  public function add()
  {	
    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
    {
      $this->template->load('error', array('title' => 'Not logged in.' , "message" => "You must be logged in to add a tag."));
      return;
    }
    $this->template->load('add_tag' , array("recipe" => 0, "tag" => 0 ));
  }
  public function submit()
  {
    $name = $this->input->post("tag_name");
    $desc = $this->input->post("description");
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

		
	
