<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Top extends CI_Controller {
    
    // ========================================================================
    // Class variable declarations
    // ========================================================================
    
    // Value for SQL LIMIT when querying the database for top results.
    protected $TOP_LIMIT = 10;
    
    // ========================================================================
    // Class function definitions
    // ========================================================================
    
    // ------------------------------------------------------------------------
    // Return all information on the top ingredients; top ingredients are those
    // that appear most often in recipes.
    //
    // http://.../top/ingredients
    // ------------------------------------------------------------------------
    
    public function ingredients()
    {
        // Create result array and empty sub-array
        $result = array("json" => array("ingredients" => array()));
        
        // Execute database query
        $query = $this->db->query("SELECT ID, Name, BaseUnitOfMeasure, "
          ."Description, ImageURL FROM Ingredients WHERE ID IN (SELECT * FROM "
          ."(SELECT IngredientsID FROM RecipesIngredients GROUP BY RecipesID "
          ."ORDER BY COUNT(RecipesID) DESC LIMIT ".$this->TOP_LIMIT.") AS "
          ."subtable) ORDER BY Name");
        
        // Append query records to result sub-array
        foreach($query->result() as $row) {
            $result["json"]["ingredients"][] = $row;
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }
}
