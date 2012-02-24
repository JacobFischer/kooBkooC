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
    
    // ------------------------------------------------------------------------
    // Class variable declarations.
    // ------------------------------------------------------------------------
    
    // Value for SQL LIMIT when querying the database for search tag
    // suggestions; does not apply to general searching.
    protected $SEARCH_TAG_NAME_LIMIT = 10;
    
    // ------------------------------------------------------------------------
    
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
<<<<<<< HEAD
    
    // ------------------------------------------------------------------------
    // Return the target string stripped of non-alphanumeric characters and
    // converted to lower case. For future-proofing and security reasons, do
    // not consider the result to be SQL-escaped.
    // ------------------------------------------------------------------------
    
    // NEED TO MAKE THIS ACTUALLY WORK SOMETIME, need to decide on a standard
    // way of expressing tags first ("Proper Capitalization" seems to be the
    // current, so lowercase here not desirable even though LIKE doesn't care).
    // Actually might not need this at all WE'LL WAIT AND SEE.
    
    public function tag_escape($target)
    {
      return strtolower($target);
    }
    
    // ------------------------------------------------------------------------
    // Return a list of ingrendient names based on the target input; the
    // database should be queried again each time the user changes the input
    // value. Use for displaying existing tags while the user is typing in the
    // search box; pass only the single ingredient currently being typed.
    //
    // http://www.foo.com/search/ingredients_like_name/target
    // ------------------------------------------------------------------------
    
    public function ingredients_like_name($target = "")
    {
        // Create result array and empty sub-array
        $result = array("json" => array("ingredients_like_name" => array()));
        
        // Set up database query
        $this->db->select("name");
        $this->db->like("name", $this->tag_escape($target), "after");
        $this->db->order_by("CHAR_LENGTH(name), name");
        $this->db->limit($this->SEARCH_TAG_NAME_LIMIT);
        
        // Execute database query
        $query = $this->db->get("Ingredients");
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["ingredients_like_name"][] = $row->name;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }
=======

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
>>>>>>> 2ff226212ea950756ef8906ccbeea65f10b2b981
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */