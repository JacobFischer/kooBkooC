<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add extends CI_Controller {

    public function index()
    {
        $this->home();
    }
    
    public function home()
    {    
        $tagquery= $this->db->query("SELECT * FROM Tags");
        $ingredientsquery=$this->db->query("SELECT * FROM Ingredients");       
        $this->template->load_js("recipe_add.js");
        $this->template->load( 'recipe_add', array("tags" => $tagquery->result(),
                                            "ingredients" => $ingredientsquery->result()));
    }
    
    public function help()
    {
        $this->template->load( 'page_help');
    }
}

/* End of file add.php */
/* Location: ./application/controllers/page.php */