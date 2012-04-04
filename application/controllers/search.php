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
    // Return all information on ingredients contained in the search results.
    //
    // `target` refers to the ingredient name. The default value is the empty
    // string; the result set obtained by searching against this value will be
    // all existing ingredients.
    //
    // `page` refers to a perceived page number and not to the SQL OFFSET
    // value; that is, the first page is 1, the second is 2, and so on. The
    // default value is 1.
    //
    // http://.../search/ingredients/__target__/__page__
    // ------------------------------------------------------------------------
    
    public function ingredients($target = "", $page = 1)
    {
        // Check invalid page
        if($page < 1) {
            $page = 1;
        }
        
        // Create result array and empty sub-array
        $result = array("json" => array("ingredients" => array()));
        
        // Assign limit, offset, and target
        $limit = $this->SEARCH_TAG_PAGE_OFFSET;
        $offset = ($page - 1) * $this->SEARCH_TAG_PAGE_OFFSET;
        $target = $this->tag_escape($target);
        
        if(strlen($target)) {
            // Prepare statement (select where target at beginning)
            $this->db->select("ID, Name, BaseUnitOfMeasure, Description, "
              ."ImageURL");
            $this->db->like("Name", $target, "after");
            $this->db->order_by("Name");
            $this->db->limit($limit, $offset);
            
            // Execute statement
            $query1 = $this->db->get("Ingredients");
            
            // Clear query cache
            $this->db->flush_cache();
            
            // Prepare statement (select where target only within)
            $this->db->select("ID, Name, BaseUnitOfMeasure, Description, "
              ."ImageURL");
            $this->db->like("Name", $target, "both");
            $this->db->not_like("Name", $target, "after");
            $this->db->order_by("Name");
            $this->db->limit($limit, $offset);
            
            // Execute statement
            $query2 = $this->db->get("Ingredients");
            
            // Append query records to result sub-array
            foreach($query1->result() as $row) {
                $result["json"]["ingredients"][] = $row;
            }
            
            foreach($query2->result() as $row) {
                $result["json"]["ingredients"][] = $row;
            }
        }
        else {
            // Prepare statement (select without pattern matching)
            $this->db->select("ID, Name, BaseUnitOfMeasure, Description, "
              ."ImageURL");
            $this->db->order_by("Name");
            $this->db->limit($limit, $offset);
            
            // Execute statement
            $query = $this->db->get("Ingredients");
            
            // Append query records to result sub-array
            foreach($query->result() as $row) {
                $result["json"]["ingredients"][] = $row;
            }
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', array_slice($result, 0, $limit,
          TRUE));
    }
    
    /*
    // ------------------------------------------------------------------------
    // Return all information on ingredients selected based on the target
    // input. Use for general ingreadient searching.
    //
    // http://.../search/ingredients/target
    // ------------------------------------------------------------------------
    
    public function ingredients($target = "")
    {
        // Create result array and empty sub-array
        $result = array("json" => array("ingredients" => array()));
        
        // Prepare database query
        $this->db->select("id, name, baseunitofmeasure, description, "
          ."imageurl");
        $this->db->like("name", $this->tag_escape($target));
        $this->db->order_by("CHAR_LENGTH(name), name");
        $this->db->limit($this->SEARCH_TAG_GENERAL_LIMIT);
        
        // Execute database query
        $query = $this->db->get("Ingredients");
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["ingredients"][] = $row;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }
    */
    
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

  public function get()
  {
      $q = $this->input->get('ingredient', TRUE);
  }
  
  public function reverse()
  {
	// create data object mapped to json
    $data = array("json" => array("recipe" => array() ) );
	
	if (isset($_GET["ingredients"]))
	{
		$ingredients = $_GET["ingredients"];
	}
	else
	{
		$this->load->view('search_json', $data);
		return;
	}
    
    $query = array();
    // Build query
	
	/*$ingredientString = "";
	foreach($ingredients as $ingredient)
	{
		$ingredientString += 
	}*/
	
	$query = $this->db->query("SELECT re.ID, re.SubmitterUsersID, re.Name, re.Directions, re.Servings, re.ImageURL, re.Description, us.DisplayName, SUM(vo.Direction) AS VoteSum 
	                  FROM Recipes re 
					  INNER JOIN RecipesIngredients ri ON re.ID = ri.RecipesID 
					  INNER JOIN Votes vo ON re.ID = vo.RecipesID 
					  INNER JOIN Users us ON re.SubmitterUsersID = us.ID 
					  WHERE ri.IngredientsID IN 
						(SELECT ID 
						 FROM Ingredients 
						 WHERE Name IN ('Cheese')) 
					  GROUP BY vo.RecipesID ORDER BY VoteSum DESC;
					  ");
	
	/*$this->db->select('*');
    $this->db->from('Recipes');
    $this->db->join('RecipesIngredients','Recipes.ID = RecipesIngredients.RecipesID');
	$this->db->join('Votes','Recipes.ID = Votes.RecipesID');
	$this->db->group_by('Recipes.ID','asc'); */
	
	
    /*
    {
	  //$this->db->where_in("RecipesIngredients.IngredientsID",$ingredient);
      //$this->db->select('*');
      //$this->db->from('Recipes');
      //$this->db->join('RecipesIngredients','Recipes.ID = RecipesIngredients.RecipesID');
      //
      //$this->db->like("IngredientsID", $ingredient);
      //
      // Execute query
    }*/
    //$query = $this->db->get();
	
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
  
  // ##########################################################################
  // START UNKNOWN HERE
  // IF THIS IS YOUR FUNCTION PLEASE FIX IT
  // but I think it's just old code that got left behind in a merge conflict
  // ##########################################################################
  
  /*
  
  public function WHAT_IS_THIS_FUNCTION($ingredients)
  {
        // create data object mapped to json
        $data = array("json" => array("recipe" => array() ) );
        
        // Build query
        $this->db->select('*');
        $this->db->from('Recipes');
        $this->db->like('Description',$text);
		
		$data = array("json" => array("recipes" => array() ) );
		if (isset($ingredients))
		{
			// create data object mapped to json
			//$query = new 
			
			// Build query
			$ings = "";
			foreach ($ingredients as $ingredient)
			{
				$ings .= "$ingredient, ";
			}
			
			$this->db->select('*');
			$this->db->from('Recipes');
			$query = $this->db->get();
			
			$i = 0;
			foreach($query->result() as $recipe)
			{
				$data['json']['recipes'][$i] = $recipe;
				$i++;
			}
			
      
			//$this->db->select('*');
			//$this->db->from('Recipes');
			//$this->db->join('RecipesIngredients','Recipes.ID = RecipesIngredients.RecipesID','inner');
			//$this->db->join('Votes','Recipes.ID = Votes.RecipesID');
			//$this->db->where_in("IngredientsID", "( $ings )");
			//$this->db->order_by("SUM('Votes.Direction')",'asc');
			
			//// Execute query
			//$query = $this->db->get();
			
			//$i = 0;
			//foreach($query->result() as $recipe)
			//{
			//	$data['json']['recipes'][$i] = $recipe;
			//	$i++;
			//}
		}	
		
		// return the recipes to the "views/search_json.php" view so it can build valid JSON from the data
		$this->load->view('search_json', $data);
		

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
    
    */
    
    // ########################################################################
    // END OF UNKNOWN
    // ########################################################################

    /////////////////////////////////////////////////////////////////////////////////////////
       // The basic JSON search function for Tags
       // http://home.jacobfischer.me/USERNAME/cs397/index.php/search/tags/
       public function tags()
       {
         // We want to return the $data object with a map key to json, and in the  json we are building the cookware
         $data = array("json" => array("tags" => array() ) );
        
         // Build the SQL-ish query using CodeIgniters's Active Record
         $this->db->select('*');
         $this->db->from('Tags');
        
         // Actually execute the SQL Query on the database
         $query = $this->db->get();
        
         // Iterate through each result in the query and build the cookware to  return
         $i = 0;
         foreach($query->result() as $tags)
         {
            $data['json']['tags'][$i] = $tags;
            $i++;
         }
        
        // return the tags to the "views/search_json.php" view so it can build  valid JSON from the data
        $this->load->view('search_json', $data);
      }
      /////////////////////////////////////////////////////////////////////////////////////////



 /////////////////////////////////////////////////////////////////////////////////////////
          // ------------------------------------------------------------------------
    // Return all information on tags selected based on the target
    // input; note that page refers to a perceived page number and not to the
    // SQL OFFSET value. Use for general tag searching.
    //
    // http://home.jacobfischer.me/USERNAME/cs397/index.php/search/tag/_tagname_/_page#_
    // ------------------------------------------------------------------------
    
    public function tag($target = "", $page = 1)
    {
        // Check invalid page
        if($page < 1) {
            $page = 1;
        }
        
        // Create result array and empty sub-array
        $result = array("json" => array("tag" => array()));
        
        // Prepare database query //////////////////////////////////////////////////////
        $this->db->select("ID, Name, Description");
        $this->db->like("Name", $this->tag_escape($target), "after");
        $this->db->order_by("CHAR_LENGTH(Name), Name");
        
        if(strlen($target)) {
            $this->db->limit($this->SEARCH_TAG_GENERAL_LIMIT,
              ($page - 1) * $this->SEARCH_TAG_PAGE_OFFSET);
        }///////////////////////////////////////////////////////////////////////////////
        
        // Execute database query
        $query = $this->db->get("Tags");
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["tag"][] = $row;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }

//>>>>>>> 2d41820e31e995b1b518e402049914b619b757bc
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
