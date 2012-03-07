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
    
    // Value for SQL LIMIT when querying the database for general search
    // results; use to prevent unnecessary result preparation in case of very
    // large result sets.
    protected $SEARCH_TAG_GENERAL_LIMIT = 5000;
    
    // Value for SQL LIMIT when querying the database for general search
    // results; use to prevent unnecessary result preparation in case of very
    // large result sets.
    protected $SEARCH_TAG_PAGE_OFFSET = 25;
    
    // ------------------------------------------------------------------------
    // Return the target string stripped of non-alphanumeric characters and
    // converted to lower case. For future-proofing and security reasons, do
    // not consider the result to be SQL-escaped.
    // ------------------------------------------------------------------------
    
    public function tag_escape($target)
    {
      return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $target));
    }
    
    // ------------------------------------------------------------------------
    
    public function index()
    {
        // data map with one variable, "$json" which is anouther map for
        // whatever data you want to see in json
        $data = array("json" => array());
        
        $data["json"] = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        $this->load->view('search_json', $data);
        
        // templated view:
        //$this->template->load('template', 'welcome_message', $data);
    }
    
    // ------------------------------------------------------------------------
    
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

    // ------------------------------------------------------------------------
    // Return all information on ingredients selected based on the target
    // input; note that page refers to a perceived page number and not to the
    // SQL OFFSET value. Use for general ingreadient searching.
    //
    // http://.../search/ingredients/__target__/__page__
    // ------------------------------------------------------------------------
    
    public function ingredients($target = "", $page = 1)
    {
        // Check invalid page
        if($page < 1) {
            $page = 1;
        }
        
        // Decrement page number
        $page--;
        
        // Escape target string
        //
        // ##############
        // DO NOT MODIFY!
        // ##############
        $target = $this->db->escape_like_str($this->tag_escape($target));
        
        // Create result array and empty sub-array
        $result = array("json" => array("ingredients" => array()));
        
        // Execute database query
        if(strlen($target)) {
            //$query = $this->db->query("SELECT DISTINCT ID, Name, BaseUnitOfMeasure, Description, ImageURL FROM ((SELECT ID, Name, BaseUnitOfMeasure, Description, ImageURL, 0 AS SortOrder FROM Ingredients WHERE Name LIKE '{$target}%') UNION (SELECT ID, Name, BaseUnitOfMeasure, Description, ImageURL, 1 AS SortOrder FROM Ingredients WHERE Name LIKE '%{$target}%')) ORDER BY SortOrder, Name LIMIT {$this->SEARCH_TAG_PAGE_OFFSET} OFFSET {$page * $this->SEARCH_TAG_PAGE_OFFSET}");
        }
        else {
            $query = $this->db->query("SELECT DISTINCT ID, Name, BaseUnitOfMeasure, Description, ImageURL FROM Ingredients ORDER BY Name LIMIT {$this->SEARCH_TAG_PAGE_OFFSET} OFFSET {$page * $this->SEARCH_TAG_PAGE_OFFSET}");
        }
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["ingredients"][] = $row;
        }
		
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }
    
    // ------------------------------------------------------------------------
    // Return a short list of ingrendient names based on the target input; the
    // database should be queried again each time the user changes the input
    // value. Use for displaying existing tags while the user is typing in the
    // search box; pass only the single ingredient currently being typed.
    //
    // http://.../search/ingredients_like_name/__target__/__page__
    // ------------------------------------------------------------------------
    
    public function ingredients_like_name($target = "")
    {
        // Create result array and empty sub-array
        $result = array("json" => array("ingredients_like_name" => array()));
        
        // Prepare database query
        $this->db->select("Name");
        $this->db->like("Name", $this->tag_escape($target), "after");
        $this->db->order_by("CHAR_LENGTH(Name), Name");
        
        if(strlen($target)) {
            $this->db->limit($this->SEARCH_TAG_NAME_LIMIT);
        }
        
        // Execute database query
        $query = $this->db->get("Ingredients");
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["ingredients_like_name"][] = $row->Name;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }
    
    // ------------------------------------------------------------------------
     
    public function recipe($text = "default" )
    {
	$data = array("json" => array("recipe" => array() ) );
        // create data object mapped to json
      
          // Build query
          $this->db->select('*');
          $this->db->from('Recipes');
          $this->db->like('Description',$text);
          // Execute query
          $query = $this->db->get();
          // Iterate through each result in the query and build the cookware to return
          $i = 0;
          foreach($query->result() as $recipe)
          {
              $data['json']['recipe'][$i] = $recipe;
              $i++;
          }
    	   $this->db->flush_cache();
	   $this->db->select('*');
	   $this->db->from('Recipes');
	   $this->db->like('Directions',$text);
	   $query = $this->db->get();
	   $same = 0;
	   foreach($query->result() as $result)
          {
	     for($j=0; $j<$i; $j++)
	     {
		if($data['json']['recipe'][$j]==$result)
		{
                $same=1;
		}
	     }
	     if($same==0)
	     {
               $data['json']['recipe'][$i]=$result;
		 $i++;
	     }
            $same=0;

          }
        // return the recipes to the "views/search_json.php" view so it can build valid JSON from the data
        $this->load->view('search_json', $data);
    }
	
	// ------------------------------------------------------------------------
	//  This function is for taking ingredients and returning the corresponding
	//  recipes.
	// ------------------------------------------------------------------------
	
	public function reverse($ingredientID = 1)
	{
		// create data object mapped to json
        $data = array("json" => array("recipe" => array() ) );
        
        // Build query
        $this->db->select('*');
        $this->db->from('Recipes');
		$this->db->join('RecipesIngredients','Recipes.ID = RecipesIngredients.RecipesID');
		$this->db->join('Votes','Recipes.ID = Votes.RecipesID');
		$this->db->like("IngredientsID", $ingredientID);
		$this->db->order_by("SUM('Votes.Direction')",'asc');
        
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
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
