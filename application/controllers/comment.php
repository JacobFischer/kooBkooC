<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller
{
  public function index()
  {
    $this->template->load('error', array('title' => 'Page Not Done!', "message" => "We need to do this") );
  }
  
  public function add($recipeID = -1)
  {
    $contents = $this->input->post("message");
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
      $r["json"]["reason"] = "There was an error adding your comment to our database.";
      $this->load->view('json', $r);
      return;
    }
    else
    {
      $comment->ID = $query->row(0)->ID;
      $comment->DisplayName = $query->row(0)->DisplayName;
      $comment->Time = date( 'Y-m-d H:i:s');
      $comment->Text = $contents;
      $r["json"]["success"] = true;
      $r["json"]["newHTML"] = base64_encode($this->load->view('comment', array('comment' => $comment, "hide" => true ), true ));
      $this->load->view('json', $r);
      return;
    }
  }
}

