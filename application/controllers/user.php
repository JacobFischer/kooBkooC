<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function randomAlphaNum($length)
{
  $newRand = "";
  for ($i=0; $i<$length; $i++)
  { 
    $d=rand(1,30)%2; 
    $newRand .= $d ? chr(rand(65,90)) : chr(rand(48,57)); 
  }
  return $newRand; //spit it out 
} 

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

  public function reg()
  {
    $this->template->load( 'reg.php' );
  }

  public function register()
  {
    $displayName = $this->input->post( "name" );
    // PLAINTEXT
    $password = $this->input->post( "password" );
    $email = $this->input->post( "email" );
    $avatarURL = $this->input->post( "avatarURL" );

    if( strlen( $password ) < 4 )
    {
      $this->template->load('error', array('title' => 'User Registration Failed', "message" => "Please make your password at least 4 characters!") );
      return;
    }

    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('Email', $email);
    $query = $this->db->get();

    if( $query->num_rows() > 0 )
    {
      // TODO: Determine which is in use
      $this->template->load('error', array('title' => 'User Registration Failed', "message" => "E-mail is already in use!") );
      return;
    }

    $this->db->flush_cache();

    $data = array(
      'DisplayName' => $displayName,
      'Email' => $email,
      'HashedPassword' => crypt( $password ),
      'AvatarURL' => $avatarURL
    );

    $this->db->insert('Users', $data);

    $this->template->load('register_successful', array( 'username' => $displayName));
    
  }

  public function user_login()
  {
    $this->load->library('session');
    $logged_in = $this->session->userdata('logged_in');
    if( $logged_in )
    { 
      $this->template->load('error', array('title' => 'Already Logged In', "message" => "Dude! You're already logged in!") );
    }
    else
    {
      $this->template->load( 'user_login.php' );
    }
  }

  public function logout()
  {
    $this->load->library('session');
    $this->session->sess_destroy();

    $this->template->load( 'user_logout.php' );
  }

  public function login()
  {

    $email = $this->input->post( "email" );
    // PLAINTEXT
    $password = $this->input->post( "password" );

    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('Email', $email );

    $query = $this->db->get();
    if( $query->num_rows == 1 )
    {
      
      if(crypt($password, $query->row(0)->HashedPassword ) ==  $query->row(0)->HashedPassword)
      {
        $this->load->library('session');
        $userData = array( 'email' => $email, 'logged_in' => TRUE );
        $this->session->set_userdata($userData);

        $this->template->load('login_successful', array() );
        return;
      }
      else
      {
        $this->template->load('error', array('title' => 'User Login Failed', "message" => "Invalid password!") );
        return;
      }

    }
    else
    {
      $this->template->load('error', array('title' => 'User Login Failed', "message" => "A user with that email does not exist!") );
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
  
  public function password_reset($userID = -1)
  {
    if($userID < 0)
    {
      $this->template->load('error', array('title' => 'Password Reset Failed', "message" => "Invalid User ID supplied for password reset.") );
      return;
    }
    
    $newPassword = randomAlphaNum(12);
    
    $this->load->library('email');
    
    $config['protocol'] = 'mail';
    $config['mailtype'] = 'html';
    $config['charset']  = 'utf-8';
    $config['newline']  = "\r\n";
    $this->email->initialize($config);
    
    $this->email->from('noreply@koobkooc.net', 'kooBkooC');
    $this->email->to('jtf3m8@mst.edu'); 

    $this->email->subject('kooBkooC Password Reset');
    $this->email->message("Your new password on kooBkooC.net is: <strong>$newPassword</strong>");

    $this->email->send();
    
    $this->template->load('error', array('title' => 'Worked for ' . $userID, "message" => $this->email->print_debugger()) );
  }
}
