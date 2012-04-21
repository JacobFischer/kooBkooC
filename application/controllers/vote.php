<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {

  public function manual($direction = "none", $recipeID = -1)
  {
    $jsonResponse = array("json" => array());
    $jsonResponse["json"]["success"] = false;
    
    if($direction != "up" && $direction != "down" && $direction != "neutral")
    {
      $jsonResponse["json"]["reason"] = "The direction you voted on is invalid.";
      $this->load->view('json', $jsonResponse);
      return;
    }
    
    $dir = 0;
    if($direction == "up")
    {
      $dir = 1;
    }
    else if($direction == "down")
    {
      $dir = -1;
    }
    
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->where('ID', $recipeID);
    $query = $this->db->get();
    
    if($recipeID == -1 || $query->num_rows() == 0)
    {
      $jsonResponse["json"]["reason"] = "The recipe you voted could not be found.";
      $this->load->view('json', $jsonResponse);
      return;
    }

    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('Email', $this->session->userdata('email'));

    $query = $this->db->get();

    if(!$this->session->userdata('logged_in') || !$this->session->userdata('email') || $query->num_rows() != 1)
    {
      $jsonResponse["json"]["reason"] = "You must be logged in to vote.";
      $this->load->view('json', $jsonResponse);
      return;
    }
    
    $id = $query->row(0)->ID;
    $data = array(
      'UsersID' => $id,
      'RecipesID' => $recipeID, 
      'Direction' => $dir,
    );
    
    $this->db->flush_cache();

    $this->db->select('*');
    $this->db->from('Votes');
    $this->db->where('UsersID', $id);
    $this->db->where('RecipesID', $recipeID);

    $query = $this->db->get();
    
    if($query->num_rows() == 0)
    {
      $this->db->flush_cache();
      $this->db->set($data);
      $this->db->insert('Votes');
    }
    else
    {
      $this->db->flush_cache();
      $this->db->where('UsersID', $id);
      $this->db->where('RecipesID', $recipeID);
      $this->db->update('Votes', $data);
    }

    // Get the total of votes for this recipe, as it has changed
    $this->db->select('*');
    $this->db->from('Votes');
    $this->db->where('RecipesID', $recipeID);
    $this->db->select_sum('Direction');
    $votequery = $this->db->get();
    
    $jsonResponse["json"]["success"] = true;
    $jsonResponse["json"]["direction"] = $direction;
    $jsonResponse["json"]["recipeID"] = $recipeID;
    $jsonResponse["json"]["total"] = (int)$votequery->row(0)->Direction;
    $this->load->view('json', $jsonResponse);
  }
  
  public function up($recipeID = -1)
  {
    $this->manual("up", $recipeID);
  }
  
  public function down($recipeID = -1)
  {
    $this->manual("down", $recipeID);
  }
  
  public function neutral($recipeID = -1)
  {
    $this->manual("neutral", $recipeID);
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
