<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/search/<method_name>
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
    
    public function cookware()
    {
        // An array of cookware to return
        $cookwareToReturn = array();
        
        // Build the SQL-ish query using CodeIgniters's Active Record
        $this->db->select('*');
        $this->db->from('Cookware');
        
        // Actually execute the SQL Query on the database
        $query = $this->db->get();
        
        // Iterate through each result in the query and build the cookware to return
        $i = 0;
        foreach($query->result() as $cookware)
        {
            $cookwareToReturn[$i] = $cookware;
            /*$cookwareToReturn[$i] = array
            (
                "ID" => $cookware->ID,
                "Description" => $cookware->Description,
                "Name" => $cookware->Name,
                "ImageURL" => $cookware->ImageURL
            );*/
            $i++;
        }
        
        // return the cookware to the "views/search_json.php" view so it can build valid JSON from the data
        $data = array("json" => array("cookware" => $cookwareToReturn) );
        $this->load->view('search_json', $data);
    }
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */