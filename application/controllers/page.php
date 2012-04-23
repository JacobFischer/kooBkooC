<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

  public function index()
  {
    $this->home();
  }
  
  public function home()
  {
    $this->template->load_js("submit_guess.js");
    $this->template->load_js("frontPageSearch.js");
    $this->template->set_location("Home");
    $this->template->load( 'page/home', array( 'ingredients' => $this->db->query("SELECT * FROM Ingredients")->result() ) );
  }
  
  public function help()
  {
    $this->template->load( 'page/help' );
  }
  
  public function about_us()
  {
    $this->template->set_location( "About Us" );
    $this->template->load( 'page/about_us' );
  }
  
  public function faqs()
  {
    $this->template->set_location( "FAQs" );
    $this->template->load( 'page/faqs' );
  }
  
  public function contact_us()
  {
    $this->template->set_location( "Contact Us" );
    $this->template->load( 'page/contact_us' );
  }
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */