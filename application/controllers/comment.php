<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller {

    public function index()
    {
      $this->template->load('error', array('title' => 'Page Not Done!', "message" => "We need to do this") );
    }
    
    public function add($userid,$recipeid, $contents)
    {
        $this->template->load_js("recipe_id.js");
        $data = array('ID' => $id,'UsersID'=>$userid,'ParentCommentsID' => 0, 'RecipesID' => $recipeid, 'Text' => $contents, 'Time' => $time);
        // Build the SQL-ish query using CodeIgniters's Active Record to get the Cookware with the id passed in
        
        
        if(!($this->db->insert("Comments",$data)) )
        {
            $this->template->load('error', array('title' => 'Recipe Not Found!', "message" => "The Recipe with id \"$id\" could not be found!") );
        }
        else
        {
            $this->template->load('recipe_id',0);
        }
    }
}

