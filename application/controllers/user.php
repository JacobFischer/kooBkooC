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

      // Retrieve this user's submitted recipes
      $this->db->flush_cache();
      $this->db->select('*');
      $this->db->from('Recipes');
      $this->db->join('Users', 'Recipes.SubmitterUsersID = Users.ID' );
      $this->db->where('SubmitterUsersID', $id );
      $query = $this->db->get();
      $recipes = $query->result();

      // Retrieve this user's favorites
      $this->db->flush_cache();
      $this->db->select('*');
      $this->db->from('Recipes');
      $this->db->join('Favorites', 'Recipes.ID = Favorites.RecipesID' );
      $this->db->join('Users', 'Favorites.UsersID = Users.ID' );
      $this->db->where('Users.ID', $id );
      $query = $this->db->get();
      $favorites = $query->result();

      // Retrieve this user's allergies
      $this->db->flush_cache();
      $this->db->select('*');
      $this->db->from('Allergies');
      $this->db->join('UsersAllergies', 'UsersAllergies.AllergiesID = Allergies.ID' );
      $this->db->where('UsersAllergies.UsersID', $id );
      $query = $this->db->get();
      $allergies = $query->result();

      // Retrieve this user's stalkers
      $this->db->flush_cache();
      $this->db->select('*');
      $this->db->from('Users');
      $this->db->join('Followings', 'Users.ID = Followings.StalkerUsersID' );
      $this->db->where('Followings.StalkingUsersID', $id);
      $query = $this->db->get();
      $stalkers = $query->result();

      // Retrieve who this user's stalking
      $this->db->flush_cache();
      $this->db->select('*');
      $this->db->from('Users');
      $this->db->join('Followings', 'Users.ID = Followings.StalkingUsersID' );
      $this->db->where('Followings.StalkerUsersID', $id);
      $query = $this->db->get();
      $stalking = $query->result();
    
      $this->template->load('user_id', array('info' => $user_info, 'recipes' => $recipes, 'favorites' => $favorites, 'allergies' => $allergies, 'stalkers' => $stalkers, 'stalking' => $stalking ) );
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
