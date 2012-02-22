<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

  public function _remap( $method )
  {
    if( $method == 'name' )
    {
      $this->default_method();
      print $method;
    }
    else
    {
      index( $method );
    }

  }

  public function index( $id )
  { 
    $this->db->flush_cache();
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('ID', $id );

    $this->template->load('error', array('title' => 'Cookware Not Found!', "message" => "The Cookware with id \"$id\" could not be found!") );
    // print $name;
  }


  public function name($username)
  {
    $this->db->select('ID');
    $this->db->from('Users');
    $this->db->where('DisplayName', $username );

    $query = $this->db->get();

    if( $query->num_rows() == 1 )
    {
      $id = $query->row(0)->ID;
      index( $id );
    } 
    else
    {
      $this->template->load('error', array('title' => 'Username Not Found', "message" => "The username \"$username\" could not be found!") );
    }
    
  }
}
