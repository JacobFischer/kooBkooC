<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

    /**
     * Basic Info:
     *
     * Controlls are Maped to the following URL
     *    http://home.jacobfischer.me/USERNAME/cs397/index.php/search/FUNCTION
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    
    public function index()
    {
        // data map with one variable, "$json" which is anouther map for whatever data you want to see in json
        $data = array("json" => array());
        
        $data["json"] = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        $this->load->view('search_json', $data);
        
        // templated view:
        //$this->template->load('template', 'welcome_message', $data);
    }
    
    
    // The basic implimentation of a JSON search function for cookware
    //   ex URL: http://home.jacobfischer.me/USERNAME/cs397/index.php/search/cookware/
    public function cookware()
    {
        // We want to return the $data object with a map key to json, and in the json we are building the cookware
        $data = array("json" => array("cookware" => array() ) );
        
        // Build the SQL-ish query using CodeIgniters's Active Record
        $this->db->select('*');
        $this->db->from('Cookware');
        
        // Actually execute the SQL Query on the database
        $query = $this->db->get();
        
        // Iterate through each result in the query and build the cookware to return
        $i = 0;
        foreach($query->result() as $cookware)
        {
            $data['json']['cookware'][$i] = $cookware;
            $i++;
        }
        
        // return the cookware to the "views/search_json.php" view so it can build valid JSON from the data
        $this->load->view('search_json', $data);
    }

    public function recipe()
    {
        // create data object mapped to json
        $data = array("json" => array("recipe" => array() ) );
        
        // Build query
        $this->db->select('*');
        $this->db->from('Recipes');
        
        // Execute query
        $query = $this->db->get();
        
        // Iterate through each result in the query and build the cookware to return
        $i = 0;
        foreach($query->result() as $recipe)
        {
            $data['json']['recipe'][$i] = $recipe;
            $i++;
        }
        
        // return the recipes to the "views/search_json.php" view so it can build valid JSON from the data
        $this->load->view('search_json', $data);
    }



    //test edit
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */