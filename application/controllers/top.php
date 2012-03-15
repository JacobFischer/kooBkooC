<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Top extends CI_Controller {
    // ------------------------------------------------------------------------
    // Class variable declarations.
    // ------------------------------------------------------------------------
    
    // Value for SQL LIMIT when querying the database for top results.
    protected $TOP_QUERY_GENERAL_LIMIT = 10;
    
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
    // Return all information on the top ingredients.
    //
    // http://.../top/ingredients
    // ------------------------------------------------------------------------
    
    public function ingredients()
    {
        // Assign limit
        $limit = $this->TOP_QUERY_GENERAL_LIMIT;
        
        // Create result array and empty sub-array
        $result = array("json" => array("top_ingredients" => array()));
        
        // Execute database query
        //
        // ####################################################################
        // ENSURE THAT LIMIT IS NOT SUPPLIED BY AN UNTRUSTED SOURCE!
        // ####################################################################
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
    }
}

/* End of file top.php */
/* Location: ./application/controllers/top.php */
