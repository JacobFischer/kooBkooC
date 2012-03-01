<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {
	public function index()
	{
		$this->db->select('*');
		$this->db->from('Tags');
		$query = $this->db->get();
		if($query->num_rows() <= 0)
		{
			$this->template->load('error', array("title" => "No tags found" , "message" => "did not work"));//load error view  
			
		}
		else
		{
			$this->template->load('tag_view' , array("tag" => $query ));
		}
	}
}

		
	
