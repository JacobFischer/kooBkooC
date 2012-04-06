<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {

    public function up($recipeID = -1)
    {
      if($recipeID == -1)
      {
        $this->template->load('error', array('title' => 'Recipe Invalid!', "message" => "The recipe you voted is not here.") );
        return;
      }


      $this->load->library('session');

      if(!$this->session->userdata('logged_in') || !$this->session->userdata('email'))
      {
        $this->template->load('error', array('title' => 'Must Be Logged In To Use This Function!', "message" => "You Must Be 18 or Older In Order To Do This.") );
        return;
      }
      else
      {
        $this->db->select('*');
        $this->db->from('Users');
        $this->db->where('Email', $this->session->userdata('email'));

        $query = $this->db->get();

        if($query->num_rows() == 1)
        {

          $id = $query->row(0)->ID;
          $data = array(
            'UsersID' => $id,
            'RecipesID' => $recipeID, 
            'Direction' => 1,
          );


          $this->db->flush_cache();

          $this->db->select('*');
          $this->db->from('Votes');
          $this->db->where('UsersID', $id);

          $query = $this->db->get();
          if($query->num_rows() == 0)
          {
            $this->db->set($data);
            $this->db->insert('Votes');
          } else
          {

            $this->db->set($data);
            $this->db->update('Votes');
          }

        }

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
