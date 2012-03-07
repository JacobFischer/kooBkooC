<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetRandom extends CI_Controller {
    // ------------------------------------------------------------------------
    // Class variable declarations.
    // ------------------------------------------------------------------------
    
    // Value for SQL LIMIT when querying the database for random results.
    protected $RANDOM_QUERY_GENERAL_LIMIT = 10;
    
    // ------------------------------------------------------------------------
    // Return all information on random ingredients. If limit is not specified,
	// the default value will be used.
    //
    // http://.../random/ingredients/__limit__
    // ------------------------------------------------------------------------
    
    public function ingredients(limit = 10)
    {
	    /*
        // Create result array and empty sub-array
        $result = array("json" => array("random_ingredients" => array()));
        
        // Execute database query
        $query = $this->db->query("SELECT ID, Name, BaseUnitOfMeasure, "
          ."Description, ImageURL FROM Ingredients ORDER BY Name "
		  ."LIMIT ".$limit);
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["top_ingredients"][] = $row;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
		*/
    }
}

/* End of file random.php */
/* Location: ./application/controllers/random.php */
