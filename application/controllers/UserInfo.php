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
        // data map with one variable, "$json" which is another map for whatever data you want to see in json
        $data = array("json" => array());
        
        $data["json"] = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        $this->load->view('search_json', $data);
        
        // templated view:
        //$this->template->load('template', 'welcome_message', $data);
    }
    
    
    // The basic implimentation of a JSON search function for UserTest
    //   ex URL: http://home.jacobfischer.me/USERNAME/cs397/index.php/search/userTest/
    public function userInfo()
    {
        // We want to return the $data object with a map key to json, and in the json we are building the UserTest
        $data = array("json" => array("userTest" => array() ) );
        
        // Build the SQL-ish query using CodeIgniters's Active Record
        $this->db->select('displayName, email');
        $this->db->from('User');
        
        // Actually execute the SQL Query on the database
        $query = $this->db->get();
        
        // Iterate through each result in the query and build the info to return
        $i = 0;
        foreach($query->result() as $userInfo)
        {
            $data['json']['userInfo'][$i] = $userInfo;
            $i++;
        }
        
        // return the userTest to the "views/search_json.php" view so it can build valid JSON from the data
        $this->load->view('search_json', $data);
    }
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */