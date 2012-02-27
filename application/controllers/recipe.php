<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller {

    public function id($id)
    {
        // Build the SQL-ish query using CodeIgniters's Active Record to get the Cookware with the id passed in
        $this->db->select('*');
        $this->db->from('Recipes');
        $this->db->where('ID', $id);
        
        // Actually execute the SQL Query on the database
        $recipequery = $this->db->get();

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
        
        
        if($recipequery->num_rows() != 1)
        {
            $this->template->load('error', array('title' => 'Recipe Not Found!', "message" => "The Recipe with id \"$id\" could not be found!") );
        }
        else
        {
            $this->template->load('recipe_id', array("recipe" => $recipequery->row(0) , "vote_count" => $votequery->row(0),"comments"=> $commentquery->result() ) );
        }
    }
}

/* End of file recipe.php */
/* Location: ./application/controllers/recipe.php */