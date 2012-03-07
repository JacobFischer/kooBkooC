<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Top extends CI_Controller {
    // ------------------------------------------------------------------------
    // Class variable declarations.
    // ------------------------------------------------------------------------
    
    // Value for SQL LIMIT when querying the database for top results.
    protected $TOP_QUERY_GENERAL_LIMIT = 10;
    
    // ------------------------------------------------------------------------
    // Return all information on the top ingredients.
    //
    // http://.../top/ingredients
    // ------------------------------------------------------------------------
    
    public function ingredients(limit = 10)
    {
	    /*
        // Create result array and empty sub-array
        $result = array("json" => array("top_ingredients" => array()));
        
        // Execute database query
        $query = $this->db->query("SELECT ID, Name, BaseUnitOfMeasure, "
          ."Description, ImageURL FROM Ingredients WHERE ID IN (SELECT * FROM "
          ."(SELECT IngredientsID FROM RecipesIngredients GROUP BY RecipesID "
          ."ORDER BY COUNT(RecipesID) DESC LIMIT ".$limit.") AS subtable) "
		  ."ORDER BY Name");
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["top_ingredients"][] = $row;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
		*/
    }
}

/* End of file top.php */
/* Location: ./application/controllers/top.php */
