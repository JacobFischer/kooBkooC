<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cookware extends CI_Controller {

    public function id($id)
    {
        // Build the SQL-ish query using CodeIgniters's Active Record to get the Cookware with the id passed in
        $this->db->select('*');
        $this->db->from('Cookware');
        $this->db->where('ID', $id);
        
        // Actually execute the SQL Query on the database
        $query = $this->db->get();
        
        if($query->num_rows() != 1)
        {
            $this->template->load('error', array('title' => 'Cookware Not Found!', "message" => "The Cookware with id \"$id\" could not be found!") );
        }
        else
        {
            $this->template->load('cookware_id', array("cookware" => $query->row(0) ) );
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */