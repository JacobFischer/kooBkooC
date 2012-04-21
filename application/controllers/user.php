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

  public function getRecipes($id)
  {
    // Retrieve this user's submitted recipes
    /*$this->db->flush_cache();
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->join('Users', 'Recipes.SubmitterUsersID = Users.ID' );
    $this->db->where('SubmitterUsersID', $id );
    $query = $this->db->get();
    return $query->result();*/
    
    $usingQuery = $this->db->query("SELECT Votes.RecipesID AS ID, SUM(Direction) AS Direction, Name, Description FROM Votes JOIN Recipes on Votes.RecipesID = Recipes.ID JOIN Users on Recipes.SubmitterUsersID = Users.ID WHERE Recipes.SubmitterUsersID = \"$id\" GROUP BY Recipes.ID ORDER BY SUM(Direction) DESC" ); 
    $recipes = $usingQuery->result();

    foreach($recipes as $recipe)
    {
      $recipe->UsersVote = "0";
      
      $this->db->select('*');
      $this->db->from('Votes');
      $this->db->where('UsersID', $id );
      $this->db->where('RecipesID', $recipe->ID );
      $query = $this->db->get();
      
      if($query->num_rows() == 1)
      {
        $recipe->UsersVote = $query->row(0)->Direction;
      }
    }
    
    return $recipes;
  }

  public function getFavorites($id)
  {
    // Retrieve this user's favorites
    $this->db->select('*');
    $this->db->from('Recipes');
    $this->db->join('Favorites', 'Recipes.ID = Favorites.RecipesID' );
    $this->db->join('Users', 'Favorites.UsersID = Users.ID' );
    $this->db->where('Users.ID', $id );
    $query = $this->db->get();
    return $query->result();
  }

  public function getAllergies($id)
  {
    // Retrieve this user's allergies
    $this->db->select('*');
    $this->db->from('Allergies');
    $this->db->join('UsersAllergies', 'UsersAllergies.AllergiesID = Allergies.ID' );
    $this->db->where('UsersAllergies.UsersID', $id );
    $query = $this->db->get();
    return $query->result();
  }

  public function getStalkers($id)
  {
    // Retrieve this user's stalkers
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->join('Followings', 'Users.ID = Followings.StalkerUsersID' );
    $this->db->where('Followings.StalkingUsersID', $id);
    $query = $this->db->get();
    return $query->result();
  }

  public function getStalking($id)
  {
    // Retrieve who this user's stalking
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->join('Followings', 'Users.ID = Followings.StalkingUsersID' );
    $this->db->where('Followings.StalkerUsersID', $id);
    $query = $this->db->get();
    return $query->result();

  }
  
  public function id( $id )
  {
    $this->template->set_location("Users");
    $this->template->set_title("ID Error");
    
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where('ID', $id );

    $query = $this->db->get();

    if( $query->num_rows() == 1 )
    {
      $user_info = $query->row(0);

      $recipes = $this->getRecipes($id);
      $favorites = $this->getFavorites($id);
      $allergies = $this->getAllergies($id);
      $stalkers = $this->getStalkers($id);
      $stalking = $this->getStalking($id);
      
      $this->template->set_title( $user_info->DisplayName );
      
      $this->template->load('user/id', array('info' => $user_info, 'recipes' => $recipes, 'favorites' => $favorites, 'allergies' => $allergies, 'stalkers' => $stalkers, 'stalking' => $stalking ) );
    }
    else
    {
      $this->template->load('error', array('title' => 'Cookware Not Found!', "message" => "The Cookware with id \"$id\" could not be found!") );
    }
  }

  public function reg()
  {
    $this->template->set_location("Users");
    $this->template->set_title("Register");
    
    $this->load->library('recaptcha');
    $this->template->load( 'reg.php', array('recaptcha'=>$this->recaptcha->get_html()));
  }

  public function register()
  {
    $this->template->set_location("Users");
    $this->template->set_title("Register Complete");
    
    $displayName = $this->input->post( "name" );
    // PLAINTEXT
    $password = $this->input->post( "password" );
    $email = $this->input->post( "email" );
    $avatarURL = $this->input->post( "avatarURL" );

    $this->load->library('recaptcha');
                
    if (!$this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$this->input->post("recaptcha_response_field"))) {
      $this->template->load('error', array('title' => 'You Failed At Typing', "message" => "ReRecaptcha Please") );
      return;
    }

    if( strlen( $password ) < 8 )
    {
      $this->template->load('error', array('title' => 'User Registration Failed', "message" => "Please make your password at least eight characters!") );
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

    $this->template->load('register/successful', array( 'username' => $displayName));
    
  }

  public function user_login()
  {
    $this->template->set_location("Users");
    $this->template->set_title("Login");
    
    $this->load->library('session');
    $this->load->library('recaptcha');
    $logged_in = $this->session->userdata('logged_in');
    if( $logged_in )
    { 
      $this->template->load('error', array('title' => 'Already Logged In', "message" => "Dude! You're already logged in!") );
    }
    else
    {
      $this->template->load( 'user/login.php', array('recaptcha'=>$this->recaptcha->get_html()));
    }
  }

  public function logout()
  {
    $this->load->library('session');
    $this->session->set_userdata('logged_in', 0);
    $this->session->set_userdata('email', 0);
    $this->session->sess_destroy();

    $this->template->load( 'user/logout.php' );
    redirect('', '', 301); // send them to the home page
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

        $this->template->load('login/successful', array() );
        redirect('', '', 301);
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
      return;
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

  public function getComments($id)
  {
    $this->db->select('*');
    $this->db->from('Comments');
    $this->db->join('Recipes', 'Comments.RecipesID = Recipes.ID');
    $this->db->join('Users', 'Comments.UsersID = Users.ID');
    $this->db->where('Comments.UsersID', $id);
    $query = $this->db->get();
    
    $comments = array();
    foreach( $query->result() as $comment )
    {
      $comment->Text = $this->textile->TextileThis( $comment->Text );
      $comments[] = $comment;
    }
    
    return $query->result();
  }
  
  public function me()
  {
    $this->profile( -1, true );
  }
  
  public function profile($id = -1, $me = false)
  {
    $this->template->set_location("Users");
    $this->template->set_title("ID Error");
    
    $this->db->select('*');
    $this->db->from('Users');

    if( $me || $id == -1 )
    {
      if(!$this->session->userdata('logged_in'))
      {
        $this->template->load('error', array('title' => 'You\'re not logged in.', "message" => "You need to be logged in to see your profile") );
        return;
      }
      
      $this->db->where('Email', $this->session->userdata('email'));
    }
    else
    {
      $this->db->where('ID', $id);
    }
    
    $query = $this->db->get();
    
    if($query->num_rows == 0)
    {
      $this->template->load('error', array('title' => 'Couldn\'t find user', "message" => "We couldn't find the user specified") );
      return;
    }
    
    $user = $query->row(0);
    $this->template->set_title( $me ? "Me" : $user->DisplayName );
    $this->template->load( 'user/profile.php', array('user' => $user, 'recipes' => $this->getRecipes($user->ID), 'comments' => $this->getComments($user->ID), 'me' => $me ) );
  }
  
  public function password($page, $arg = "")
  {
    if($page == "reset")
    {
      $this->load->library('recaptcha');
      $this->template->load('user/password_reset', array('recaptcha'=>$this->recaptcha->get_html()) );
    }
    else if($page == "change")
    {
      $this->password_change();
    }
    else
    {
      $this->template->load( '404_error' );
    }
  }

  public function password_reset()
  {
    $this->load->library('recaptcha');
    $this->db->from('Users');
    $email = $this->input->post( "email" );
    $this->db->where('email', $email);
    $query = $this->db->get();
    
    if($query->num_rows() != 1)
    {
      $this->template->load('error', array('title' => 'Password Reset Failed', "message" => "Invalid User ID supplied for password reset.") );
      return;
    }
    
    if (!$this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$this->input->post("recaptcha_response_field"))) {
      $this->template->load('error', array('title' => 'You Failed At Typing', "message" => "ReRecaptcha Please") );
      return;
    }

    $user = $query->row(0);
    
    $newPassword = randomAlphaNum(12);
    
    $this->load->library('email');  
    
    $this->email->from('koobkooc.net@gmail.com', 'kooBkooC.net');
    $this->email->to( $user->Email ); 

    $this->email->subject('kooBkooC.net Password Reset');
    $this->email->message("<p>Your new password on kooBkooC.net is: <strong>$newPassword</strong> </p><p>enjoy,<br />The kooBkooC Team</p>");

    $this->email->send();
    
    $this->db->flush_cache();
    $this->db->where('ID', $user->ID);
    $this->db->update('Users', array( 'HashedPassword' => crypt( $newPassword ) ) );
    
    $this->template->load('user/password_sent', array('email' => $user->Email ) );
  }
  
  public function password_change()
  {
    if($this->session->userdata('logged_in'))
    {
      $email = $this->session->userdata('email');
      $this->db->select('*');
      $this->db->from('Users');
      $this->db->where('Email', $email);

      $query = $this->db->get();
      if($query->num_rows == 1)
      {

        $oldPassword = $this->input->post( "oldPassword" );
      
        if(crypt($oldPassword, $query->row(0)->HashedPassword ) !=  $query->row(0)->HashedPassword)
        {
          $this->template->load('error', array('title' => 'Your old password is incorrect.', "message" => "Please try to remember better!") );
          return;
        }
        

        $password1 = $this->input->post( "password1" );
        $password2 = $this->input->post( "password2" );


        if($password1 != $password2)
        {
          $this->template->load('error', array('title' => 'Passwords Do Not Match', "message" => "Match your passwords before wasting my time!") );
          return;
        }
        else if(strlen($password1) < 8)
        {
          $this->template->load('error', array('title' => 'Password Too Short', "message" => "Your password must be eight or more characters in length!") );
          return;
        }

        $data = array(
          'DisplayName' => $query->row(0)->DisplayName,
          'Email' => $query->row(0)->Email,
          'HashedPassword' => crypt( $password1 ),
          'AvatarURL' => $query->row(0)->DisplayName        
        );

        $this->db->where('Email', $email);
        $this->db->update('Users', $data);
        
        $this->template->load('error', array('title' => 'Password Changed', "message" => "Goodjob!!") );
        return;
      }
    }

    $this->template->load('error', array('title' => 'You\'re not logged in.', "message" => "This would go a lot easier if you'd just log in!") );

  }
  
  public function lookup()
  {
    $this->template->set_location("User");
    $this->template->set_title("Lookup");
    $this->template->load_js("submit_guess.js");
    $this->template->load_js("user_lookup.js");
    $this->template->load( 'user/lookup.php' );
  }

}

?>
