<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Aboutus extends CI_Controller{

//Programmer: Michael Wilson
//function: index
//load view for about us page
public function index()
{
  $this->template->load('about_usview');
}
}




