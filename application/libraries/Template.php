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