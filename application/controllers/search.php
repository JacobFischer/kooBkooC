<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
//Unit Tests by Brian Yocum
    /**
     * Basic Info:
     *
     * Controlls are Maped to the following URL
     *    http://home.jacobfischer.me/USERNAME/cs397/index.php/search/FUNCTION/page#/runtest
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
    //
    // Cody Williams
    // ------------------------------------------------------------------------
    
    public function tag_escape($target)
    {
      return trim(preg_replace('/[^a-zA-Z0-9 ]/', '', urldecode($target)));
    }
    
    // ------------------------------------------------------------------------
    
    public function id_escape($target)
    {
      return preg_replace('/[^0-9]/', '', $target);
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
    
//--------------------------------------------------------------------------------------------------------
//BEGIN COOKWARE SEARCH
   
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


//END COOKWARE SEARCH
//--------------------------------------------------------------------------------------------------------
//BEGIN INGREDIENTS SEARCH    


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
    //
    // Cody Williams
    // ------------------------------------------------------------------------
    public function ingredients($target = "", $page = 1, $runtest=FALSE)
    {
        $numRows = 0;
        $numRows2 = 0;
        $this->load->library('unit_test');
        
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
            
            // Run test suite
            if($runtest==TRUE)
            {
                $numRows+=$query1->num_rows();
            }
            
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
            
            // Tests to see if either query generated results
            if($runtest == TRUE)
            {
                $numRows2 += $query2->num_rows();
                
                $this->unit->run(($numRows2 + $numRows > 0), TRUE,
                  "Ingredient Query Successful", "Query1 (Match%) generated "
                  ."${numRows} result(s) | Query2 (%Match%) generated "
                  ."${numRows2} result(s)");
                
                $numRows += $numRows2;
            }
            
            $i = 1;
            $target = strtolower($target);
            
            // Append query records to result sub-array
            foreach($query1->result() as $row) {
                // Tests to see if results from query1 match the search target
                if($runtest == TRUE)
                {
                    $rowName = strtolower($row->Name);
                    
                    if($rowName == $target) {
                        $this->unit->run($rowName, $target, "Query 1: Exact "
                          ."Ingredients Match% (Result ${i})", "Verifies that "
                          ."(${rowName}) exactly matches (${target})");
                    }
                    else {
                        $this->unit->run((stripos($rowName, $target)) === FALSE,
                          FALSE, "Query 1: Partial Ingredients Match% (Result "
                          ."${i})", "Verifies that result (${rowName}) "
                          ."partially matches target (${target})");
                    }
                    
                    $i++;
                }
                
                $result["json"]["ingredients"][] = $row;
            }
            
            foreach($query2->result() as $row) {
                // Tests to see if results from query2 match search target
                if($runtest == TRUE) {
                    $rowName = strtolower($row->Name);
                    $this->unit->run(stripos($this->tag_escape($row->Name),
                      $target), TRUE, "Query 2: Partial Ingredients %Match% "
                      ."(Result ${i})","Verifies that result (${rowName}) "
                      ."partially matches target (${target})");
                    $i++;
                }
                
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
        
    if($runtest == TRUE) {
        // Test to verify that all results have been tested and stored as JSON,
        // then displays test results  
        $i--;
        $this->unit->run($numRows, $i, "All queried results tested and stored "
          ."as JSON (${i} out of ${numRows})", "Verifies that all results "
          ."have been tested and stored as JSON");
        
        echo $this->unit->report();
    }
    else
        // Load result records into view for retrieval
        $this->load->view('search_json', array_slice($result, 0, $limit, 
            TRUE));
    }
    
// END INGREDIENTS SEARCH  
//--------------------------------------------------------------------------------------------------------
// BEGIN RECIPE SEARCH
	/*
	//Searches for recipe names based on inputed text
	//$text refers to the input to the search
	//$runtest determines wheter to run unit testing or not
	//If runtest is set to true, then unit tests will run and 
	//and test results will be displayed, no JSON will be returned
	//Brian Yocum
	*/
    public function recipes($text = "default", $page=1, $runtest=FALSE)
    {
	$this->load->library('unit_test');
	$numRows=0;
	$numRows2=0;
	if($page < 1)
       {
          $page = 1;
       }

	// create data object mapped to json
	$data = array("json" => array("recipe" => array() ) );
       // Assign limit, offset, and text
        $limit = $this->SEARCH_TAG_PAGE_OFFSET;
        $offset = ($page - 1) * $this->SEARCH_TAG_PAGE_OFFSET;
        $text = $this->tag_escape($text);
 
      
          // Build query
        $this->db->select('*');
        $this->db->from('Recipes');
        $this->db->like('Name',$text, "after");
		$this->db->limit($limit, $offset);
        // Execute query
        $query = $this->db->get();
		//test to see if query generates any results
		if($runtest==TRUE)
		{
			$numRows += $query->num_rows();
			$this->unit->run(($numRows>0), TRUE, "Recipe Query Successfull","Query generated ${numRows} result(s)");
		}
		$i = 0;
		$text = strtolower($text);
        foreach($query->result() as $recipe)
        {
			$j=$i+1;
			//test to see if query results match input text
			if($runtest==TRUE)
			{
				$rowName = strtolower($recipe->Name);
				if($rowName==$text)
					$this->unit->run($rowName, $text, "Exact Recipe Name Match (Result {$j})",
					"Verifies that result (${rowName}) exactly matches target (${text})");
				else
					$this->unit->run((stripos($rowName, $text))===FALSE, FALSE, "Partial Recipe Name Match% (Result {$j})",
					"Verifies that result (${rowName}) partially matches target (${text})");
            }
			$data['json']['recipe'][$i] = $recipe;
            $i++;
        }
		$numRows2=$i;
    	$this->db->flush_cache();
		$this->db->select('*');
 	    $this->db->from('Recipes');
	    $this->db->like('Name',$text, "both");
		$this->db->not_like('Name',$text, "after");
	    $this->db->limit($limit, $offset);
	    $query = $this->db->get();
		//sets all results as JSON
	    foreach($query->result() as $result)
        {
			$data['json']['recipe'][$i] = $result;
            $i++;
        }
		//Verifies that all resusts have been tested and returned as JSON, then displays test results  
		if($runtest==TRUE)
		{
			$numRows2;
			$this->unit->run($numRows, $numRows2, "All queried results tested and stored as JSON (${numRows2} out of ${numRows})",
			"Verifies that all results have been tested and stored as JSON");
			echo $this->unit->report();
		}
		// return the recipes to the "views/search_json.php" viblackie1ew so it can build valid JSON from the data
		else
			$this->load->view('search_json', array_slice($data, 0, $limit,
			TRUE));

    }

//END RECIPE SEARCH
//--------------------------------------------------------------------------------------------------------
//BEGIN REVERSE SEARCH

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
        $recipes = array();
        
        //get the ingredients entered by the user from the GET array
        if (isset($_GET["ingredients"])) {
            $ingredients = $_GET["ingredients"];
            $ingredient_string = "";
        }
        else {
            //$this->load->view('search_json', $data);
            $this->load->view( 'search/reverse', array( 'recipes' => $recipes ) );
            return;
        }
        
        // Build ingredient string
        foreach($ingredients as $i) {
            $ingredient_string .= $this->db->escape_str($this->id_escape($i));
            $ingredient_string .= ", ";
	      }
        
        $ingredient_string = "(" . substr($ingredient_string, 0, -2) . ")";
        
        // Execute reverse search queries
        // Cody Williams and Lou Harmon
        for($i = sizeof($ingredients); $i > 0; $i--) {
            $query = $this->db->query("
              SELECT re.ID, re.SubmitterUsersID, re.Name, re.Directions,
                  re.Servings, re.ImageURL, re.Description, us.DisplayName,
                  SUM(vo.Direction) AS VoteSum
              FROM Recipes re
                INNER JOIN RecipesIngredients ri ON re.ID = ri.RecipesID
                INNER JOIN Votes vo ON re.ID = vo.RecipesID
                INNER JOIN Users us ON re.SubmitterUsersID = us.ID
              WHERE ri.IngredientsID IN {$ingredient_string}
              GROUP BY vo.RecipesID
                HAVING COUNT(DISTINCT ri.IngredientsID) = {$i}
              ORDER BY VoteSum DESC;
            ");
            
            // Iterate through the query and build the result
            foreach($query->result() as $recipe) {
                //$data['json']['recipe'][] = $recipe;
                $recipes[] = $recipe;
            }
        }
        
        // Find the current user
        $userID = -1;
        if($this->session->userdata('logged_in'))
        {
          $this->db->select('*');
          $this->db->from('Users');
          $this->db->where('Email', $this->session->userdata('email'));
          $query = $this->db->get();
          
          if($query->num_rows() == 1)
          {
            $userID = $query->row(0)->ID;
          }
          
          $userID = $query->row(0)->ID;
        }
        
        //find the vote sums of each recipe recieved from query
        foreach($recipes as $recipe)
        {
          $recipe->UsersVote = "0";
          $recipe->Direction = $recipe->VoteSum;
          if( $userID != -1 )
          {
            $this->db->select('*');
            $this->db->from('Votes');
            $this->db->where('UsersID', $userID );
            $this->db->where('RecipesID', $recipe->ID );
            $query = $this->db->get();
            
            if($query->num_rows() == 1)
            {
              $recipe->UsersVote = $query->row(0)->Direction;
            }
          }
        }
        
        // return the result array
        //$this->load->view('search_json', $data);
        $this->load->view( 'search/reverse', array( 'recipes' => $recipes ) );
    }

//END REVERSE SEARCH
//--------------------------------------------------------------------------------------------------------
//BEGIN TAG SEARCH
    
    ///////////////////////////////////////////////////////////////////////////////////////
    //Return JSON map with all column info for Tags whose name contains the user-entered text.
    //Function by: David Costello
    //Test integration by: 
    ///////////////////////////////////////////////////////////////////////////////////////
    public function tags($searchVal = "", $page = 1, $runtest=FALSE)
    {
	$numRows=0;
	$numRows2=0;
	$this->load->library('unit_test');
      if($page<1){$page=1;} //Validate Page Number
      $returnVal=array( "json" => array( "tags" => array() ) ); //instantiating the JSON map
      $delimiter=$this->SEARCH_TAG_PAGE_OFFSET;
      $offset=($page - 1)*$this->SEARCH_TAG_PAGE_OFFSET;
      $searchVal=$this->tag_escape($searchVal);
      /////////////////////////////////////////////////////////  
      if( strlen($searchVal) ) //if string length is not 0
      {                                               //STRUCTURING THE INITIAL QUERY
        $this->db->select("ID, Name, Description");   
        $this->db->like("Name", $searchVal, "after"); 
        $this->db->order_by("Name");                  
        $this->db->limit($delimiter, $offset);
        $initialQuery=$this->db->get("Tags");         //EXECUTE THE QUERY
		if($runtest==TRUE)
			$numRows+=$initialQuery->num_rows();
        $this->db->flush_cache();                     //flush cache
        $this->db->select("ID, Name, Description");   //STRUCTURING SECONDARY QUERY
        $this->db->like("Name", $searchVal, "both");
        $this->db->not_like("Name", $searchVal, "after");
        $this->db->order_by("Name");
        $this->db->limit($delimiter, $offset);
        $secondaryQuery = $this->db->get("Tags");     //EXECUTE SECONDARY QUERY
		//tests to see if either query generates results
		if($runtest==TRUE)
		{
			$numRows2+=$secondaryQuery->num_rows();
			$this->unit->run((($numRows+$numRows2)>0), TRUE, 'Tag Query Successful',
			"Query1 (Match%) generated ${numRows} result(s) | Query2 (%Match%) generated ${numRows2} result(s)");
			$numRows+=$numRows2;
		}
        ///////////////////////////////////////////////////////
		$i=1;
		$searchVal = strtolower($searchVal);
        foreach($initialQuery->result() as $result)
        {
		  //tests to make sure each result matches the search value
		  if($runtest==TRUE)
		  {
			$rowName = strtolower($result->Name);
			if($rowName==$searchVal)
				$this->unit->run($rowName, $searchVal, "Query 1: Exact Tag Match% (Result ${i})");
			else
				$this->unit->run((stripos($rowName, $searchVal))===FALSE, FALSE, "Query 1: Partial Ingredients Match% (Result ${i})",
				"Verifies that result (${rowName}) partially matches target (${searchVal})");
          }
		  $returnVal["json"]["tags"][] = $result;  //assigning value to the JSON map

		  $i++;
        }
        foreach($secondaryQuery->result() as $result)
        {
		  //tests to make sure all secondary query results match search value
		  if($runtest==TRUE)
		  {
			$rowName = strtolower($result->Name);
			$this->unit->run(stripos($rowName, $searchVal), TRUE, "Query 2: Partial Tag %Match% (Result ${i})",
			"Verifies that result (${rowName}) partially matches target (${searchVal})");
		  }
          $returnVal["json"]["tags"][] = $result;  //assigning value to the JSON map

		  $i++;
        }
      }
      /////////////////////////////////////////////////////////
      else  //is string length is 0, return all tags
      {
        $this->db->select("ID, Name, Description");
        $this->db->order_by("Name");
        $this->db->limit($delimiter, $offset);
        $query = $this->db->get("Tags");
        foreach($query->result() as $result)
        {
          $returnVal["json"]["tags"][] = $result;  //assigning value to the JSON map
        }
      }
      ///////////////////////////////////////////////////////// 
	  //test to verify all results have been tested and stored as JSON, then displays test results  
	  if($runtest==TRUE)
	  {
		$i--;
		$this->unit->run($numRows, $i, "All queried results tested and stored as JSON (${i} out of ${numRows})",
		"Verifies that all results have been tested and stored as JSON");
		echo $this->unit->report();
	  }
	  else
		$this->load->view( 'search_json', array_slice($returnVal, 0, $delimiter, TRUE) );
    }
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////

//END TAG SEARCH
//--------------------------------------------------------------------------------------------------------

    // The basic implimentation of a JSON search function for user
    //   ex URL: http://home.jacobfischer.me/USERNAME/cs397/index.php/search/user/
    public function user($target = "")
    {
        // Create result array and empty sub-array
        $result = array("json" => array("users" => array()));
        
        // Prepare database query
        $this->db->select("ID, DisplayName, Email ");
        $this->db->like("DisplayName", $target);
        $this->db->order_by("CHAR_LENGTH(DisplayName), DisplayName");
        $this->db->limit($this->SEARCH_TAG_GENERAL_LIMIT);

        // Execute database query
        $query = $this->db->get("Users");
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
          $result["json"]["users"][] = $row;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
