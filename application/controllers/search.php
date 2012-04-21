<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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
    // ------------------------------------------------------------------------
    public function ingredients($target = "", $page = 1, $runtest=FALSE)
    {
	$numRows=0;
	$numRows2=0;
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
			if($runtest==TRUE)
			{
				$numRows2+=$query2->num_rows();
				$this->unit->run(($numRows2+$numRows>0), TRUE, "Ingredient Query Successful","Query1 (Match%) generated ${numRows} result(s) | Query2 (%Match%) generated ${numRows2} result(s)");
				$numRows+=$numRows2;
			}
            // Append query records to result sub-array
			
			// Run test suite
			
			// Append query records to result sub-array
			$i=1;
			$target = strtolower($target);
            foreach($query1->result() as $row) {
				if($runtest==TRUE)
				{
					$rowName = strtolower($row->Name);
					if($rowName==$target)
						$this->unit->run($rowName, $target, "Query 1: Exact Ingredients Match% (Result ${i})","Verifies that (${rowName}) exactly matches (${target})");
					else
						$this->unit->run((stripos($rowName, $target))===FALSE, FALSE, "Query 1: Partial Ingredients Match% (Result ${i})","Verifies that result (${rowName}) partially matches target (${target})");
					$i++;
				}
				
                $result["json"]["ingredients"][] = $row;
            }
            
            foreach($query2->result() as $row) {
				if($runtest==TRUE)
				{
					$rowName = strtolower($row->Name);
					$this->unit->run(stripos($this->tag_escape($row->Name), $target), TRUE, "Query 2: Partial Ingredients %Match% (Result ${i})","Verifies that result (${rowName}) partially matches target (${target})");
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
        
        // Load result records into view for retrieval
        
	if($runtest==TRUE)
	{
		$i--;
		$this->unit->run($numRows, $i, "All queried results tested and stored as JSON (${i} out of ${numRows})","Verifies that all results have been tested and stored as JSON");
		echo $this->unit->report();
	}
	else
		$this->load->view('search_json', array_slice($result, 0, $limit, 
			TRUE));
		
    }
    
// END INGREDIENTS SEARCH  
//--------------------------------------------------------------------------------------------------------
// BEGIN RECIPE SEARCH
     
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
       // Assign limit, offset, and target
        $limit = $this->SEARCH_TAG_PAGE_OFFSET;
        $offset = ($page - 1) * $this->SEARCH_TAG_PAGE_OFFSET;
        $text = $this->tag_escape($text);
 
      
          // Build query
        $this->db->select('*');
        $this->db->from('Recipes');
        $this->db->like('Name',$text);
		$this->db->limit($limit, $offset);
        // Execute query
        $query = $this->db->get();
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
			if($runtest==TRUE)
			{
				$rowName = strtolower($recipe->Name);
				if($rowName==$text)
					$this->unit->run($rowName, $text, "Exact Recipe Name Match (Result {$j})", "Verifies that result (${rowName}) exactly matches target (${text})");
				else
					$this->unit->run((stripos($rowName, $text))===FALSE, FALSE, "Partial Recipe Name Match% (Result {$j})","Verifies that result (${rowName}) partially matches target (${text})");
            }
			$data['json']['recipe'][$i] = $recipe;
            $i++;
        }
		$numRows2=$i;
    	$this->db->flush_cache();
		$this->db->select('*');
 	    $this->db->from('Recipes');
	    $this->db->like('Description',$text);
		$this->db->not_like('Name',$text);
	    $this->db->limit($limit, $offset);
	    $query = $this->db->get();
	    foreach($query->result() as $result)
        {
			$data['json']['recipe'][$i] = $result;
            $i++;
        }
        // return the recipes to the "views/search_json.php" view so it can build valid JSON from the data
		if($runtest==TRUE)
		{
			$numRows2;
			$this->unit->run($numRows, $numRows2, "All queried results tested and stored as JSON (${numRows2} out of ${numRows})","Verifies that all results have been tested and stored as JSON");
			echo $this->unit->report();
		}
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
        
        if (isset($_GET["ingredients"])) {
            $ingredients = $_GET["ingredients"];
            $ingredient_string = "";
        }
        else {
            $this->load->view('search_json', $data);
            return;
        }
        
        // Build ingredient string
        foreach($ingredients as $i) {
            $ingredient_string .= $this->db->escape_str($this->id_escape($i));
            $ingredient_string .= ", ";
	      }
        
        $ingredient_string = "(" . substr($ingredient_string, 0, -2) . ")";
        
        for($i = sizeof($ingredients); $i > 0; $i--) {
            // Execute search query
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
                $data['json']['recipe'][] = $recipe;
            }
        }
        
        // return the result array
        $this->load->view('search_json', $data);
    }

//END REVERSE SEARCH
//--------------------------------------------------------------------------------------------------------
//BEGIN TAG SEARCH
    
    ///////////////////////////////////////////////////////////////////////////////////////
    //Tag search for tags containing user entered text.
    ///////////////////////////////////////////////////////////////////////////////////////
    public function tags($searchVal = "", $page = 1, $runtest=FALSE)
    {
	$numRows=0;
	$numRows2=0;
	$this->load->library('unit_test');
      if($page<1){$page=1;} //Validate Page Number
      $returnVal=array( "json" => array( "tags" => array() ) );
      $delimiter=$this->SEARCH_TAG_PAGE_OFFSET;
      $offset=($page - 1)*$this->SEARCH_TAG_PAGE_OFFSET;
      $searchVal=$this->tag_escape($searchVal);
      /////////////////////////////////////////////////////////  
      if( strlen($searchVal) )
      {
        $this->db->select("ID, Name, Description");
        $this->db->like("Name", $searchVal, "after");
        $this->db->order_by("Name");
        $this->db->limit($delimiter, $offset);
        $initialQuery=$this->db->get("Tags");
		if($runtest==TRUE)
			$numRows+=$initialQuery->num_rows();
        $this->db->flush_cache();
        $this->db->select("ID, Name, Description");
        $this->db->like("Name", $searchVal, "both");
        $this->db->not_like("Name", $searchVal, "after");
        $this->db->order_by("Name");
        $this->db->limit($delimiter, $offset);
        $secondaryQuery = $this->db->get("Tags");
		if($runtest==TRUE)
		{
			$numRows2+=$secondaryQuery->num_rows();
			$this->unit->run((($numRows+$numRows2)>0), TRUE, 'Tag Query Successful',"Query1 (Match%) generated ${numRows} result(s) | Query2 (%Match%) generated ${numRows2} result(s)");
			$numRows+=$numRows2;
		}
        ///////////////////////////////////////////////////////
		$i=1;
		$searchVal = strtolower($searchVal);
        foreach($initialQuery->result() as $result)
        {
		  if($runtest==TRUE)
		  {
			$rowName = strtolower($result->Name);
			if($rowName==$searchVal)
				$this->unit->run($rowName, $searchVal, "Query 1: Exact Tag Match% (Result ${i})");
			else
				$this->unit->run((stripos($rowName, $searchVal))===FALSE, FALSE, "Query 1: Partial Ingredients Match% (Result ${i})","Verifies that result (${rowName}) partially matches target (${searchVal})");
          }
		  $returnVal["json"]["tags"][] = $result;
		  $i++;
        }
        foreach($secondaryQuery->result() as $result)
        {
		  if($runtest==TRUE)
		  {
			$rowName = strtolower($result->Name);
			$this->unit->run(stripos($rowName, $searchVal), TRUE, "Query 2: Partial Tag %Match% (Result ${i})","Verifies that result (${rowName}) partially matches target (${searchVal})");
		  }
          $returnVal["json"]["tags"][] = $result;
		  $i++;
        }
      }
      /////////////////////////////////////////////////////////
      else
      {
        $this->db->select("ID, Name, Description");
        $this->db->order_by("Name");
        $this->db->limit($delimiter, $offset);
        $query = $this->db->get("Tags");
        foreach($query->result() as $result)
        {
          $returnVal["json"]["tags"][] = $result;
        }
      }
      ///////////////////////////////////////////////////////// 
	  if($runtest==TRUE)
	  {
		$i--;
		$this->unit->run($numRows, $i, "All queried results tested and stored as JSON (${i} out of ${numRows})","Verifies that all results have been tested and stored as JSON");
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
