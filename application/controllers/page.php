<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

    public function index()
    {
        $this->home();
    }
    
    public function home()
    {
        $this->template->load( 'page_home' );
    }
    
    public function help()
    {
        $this->template->load( 'page_help' );
    }
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */