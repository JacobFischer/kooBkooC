<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

  public function id( $id )
  { 
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('ID', $id );

    $query = $this->db->get();

    if( $query->num_rows() == 1 )
    {
      $user_info = $query->row(0);
      $this->db->flush_cache();

      $this->db->select('*');
      $this->db->from('Recipes');
      $this->db->join('Users', 'Recipes.SubmitterUsersID = Users.ID' );
      $this->db->where('SubmitterUsersID', $id );

      $query = $this->db->get();

      $this->template->load('user_id', array('info' => $user_info, 'recipes' => $query->result() ) );
    }
    else
    {
      $this->template->load('error', array('title' => 'Cookware Not Found!', "message" => "The Cookware with id \"$id\" could not be found!") );
    }
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
      print 'I don\'t know how to call stuff from here.';

    } 
    else
    {
      $this->template->load('error', array('title' => 'Username Not Found', "message" => "The username \"$username\" could not be found!") );
    }
    
  }
}
