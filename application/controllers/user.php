<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

  public function index($id)
  { 
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('ID', $id );

    $this->template->load('error', array('title' => 'Cookware Not Found!', "message" => "The Cookware with id \"$name\" could not be found!") );
    // print $name;
  }


  public function name($name)
  {
    $this->db->select('ID');
    $this->db->from('Users');
    $this->db->where('DisplayName', $name );

    $query = $this->db->get();

    if( $query->num_rows() == 1 )
    {
      $this->template->load('error', array('title' => 'Username Not Found', "message" => "The username \"$name\" could not be found!") );
      index( $query->row(0) );
      
    } 
    else
    {
      $this->template->load('error', array('title' => 'Username Not Found', "message" => "The username \"$name\" could not be found!") );
    }
    
  }
}
