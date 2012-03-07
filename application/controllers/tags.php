<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {
	public function index()
	{
		$this->db->select('*');
		$this->db->from('Tags');
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{
			$this->template->load('error', array('title' => 'No tags found' , "message" => "did not work"));//load error view  
			
		}
		else
		{
			$this->template->load('tag_view' , array("tag" => $query ));
		}
	}

	public function recipes($id)
	{
	/*	$this->db->select('*');
		$this->db->from('Recipes');
		$this->db->where('TagID', $id);
		$this->db->get();*/
	$query = $this->db->query("SELECT * FROM RecipesTags JOIN Recipes on RecipesTags.RecipesID = Recipes.ID WHERE RecipesTags.TagsID = \"$id\" ");


		 if($query->num_rows() == 0)
                {
                        $this->template->load('error', array('title' => 'No recipes found' , "message" => "did not work"));//load error view

                }
                else
                {
                        $this->template->load('recipe_list' , array("recipe" => $query ));
                
			

		}
	}


}

		
	
