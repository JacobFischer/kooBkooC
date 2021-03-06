<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AutoCorrect extends CI_Controller {

    // ========================================================================
    // Class variable declarations
    // ========================================================================
    
    // Value for SQL LIMIT when querying the database for search tag
    // autocorrection suggestions.
    protected $AUTOCORRECT_LIMIT = 10;
    
    // ========================================================================
    // Class function definitions
    // ========================================================================
    
    // ------------------------------------------------------------------------
    // Return the target string stripped of non-alphanumeric characters and
    // converted to lower case. For future-proofing and security reasons, do
    // not consider the result to be SQL-escaped.
    //
    // Cody Williams
    // ------------------------------------------------------------------------
    
    protected function tag_escape($target)
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '',
		    urldecode($target)));
    }
    
    // ------------------------------------------------------------------------
    // Return a short list of suggested ingrendient names.
    //
    // `target` is the ingredient name currently being entered by the user into
    // the search field. The default value is the empty string; the result set
    // obtained by searching against this value is empty.
    //
    // http://.../autocorrect/ingredients/__target__
    //
    // Cody Williams
    // ------------------------------------------------------------------------
    
    public function ingredients($target = "")
    {
        // Create result array and empty sub-array
        $result = array("json" => array("ingredients" => array()));
        
        if(strlen($target)) {
            // Prepare database query
            $this->db->select("Name");
            $this->db->like("Name", $this->tag_escape($target), "after");
            $this->db->order_by("CHAR_LENGTH(Name), Name");
            $this->db->limit($this->AUTOCORRECT_LIMIT);
            
            // Execute database query
            $query = $this->db->get("Ingredients");
            
            // Append query records to result sub-array
            foreach($query->result() as $row) {
                $result["json"]["ingredients"][] = $row->Name;
            }
        }
        
        // Load result records into view for retrieval
        $this->load->view('search_json', $result);
    }
}
