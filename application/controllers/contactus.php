<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contactus extends CI_Controller{

//Programmer: Michael Wilson
//function: index 
//load view for contact us page
public function index()
{
  $this->template->load('contactus');
}

}
