<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {

    public function up($recipeID = -1)
    {
      if($recipeID == -1)
      {
        $this->template->load('error', array('title' => 'Recipe Invalid!', "message" => "The recipe you voted is not here.") );
        return;
      }

      $this->db->select('*');
      $this->db->from('Users');

      $this->load->library('session');

      if(!$this->session->userdata('logged_in'))
      {
        $this->template->load('error', array('title' => 'Must Be Logged In To Use This Function!', "message" => "You Must Be 18 or Older In Order To Do This.") );
        return;
      }
      else
      {
        
      }

    }

    public function down($recipeID = -1)
    {
      if($recipeID == -1)
      {
        $this->template->load('error', array('title' => 'Recipe Invalid!', "message" => "The recipe you voted is not here.") );
        return;
      }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
