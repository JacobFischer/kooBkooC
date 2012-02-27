<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_CONTROLLER
{
	public function index()
	{
		$this->db->select('*');
		$this->db->from('Tags');
		$query = $this->db->get();
		if($query->num_rows() < 0)
		{
			$this->template->load('error', array("tag" => "No tags found"));//load error view  
			
		}
		else
		{
			$this->template->load('tag_view' , array("tag" => $query));
		}
	}
}

		
	
