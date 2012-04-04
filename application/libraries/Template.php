<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
		var $template_data = array();
    var $scripts = array();
    var $styles = array();
		
		function set($name, $value)
		{
			$this->template_data[$name] = $value;
		}
	
		function load($view = '' , $view_data = array(), $return = FALSE)
		{     
      $this->set('scripts', $this->scripts); 
      $this->set('styles', $this->styles);       
			$this->CI =& get_instance();
			$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));			
      $this->CI->load->library('session');

      $this->set('logged_in', $this->CI->session->userdata('logged_in'));
      if($this->CI->session->userdata('logged_in'))
      {
        $email = $this->CI->session->userdata('email');
        $this->CI->db->select('*');
        $this->CI->db->from('Users');
        $this->CI->db->where('Email', $email);

        $query = $this->CI->db->get();
        if($query->num_rows == 1)
        {
          $this->set('username', $query->row(0)->DisplayName);
        }
        else
        {
          $this->set('logged_in', false);
        }
      }

			return $this->CI->load->view("template_default", $this->template_data, $return);
		}
    
    function load_js($script)
    {
      $this->scripts[] = $script;
    }
    
    function load_css($style)
    {
      $this->styles[] = $style;
    }
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */
