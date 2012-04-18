<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faqs extends CI_Controller{

//Programmer: Michael Wilson
//function: index
//load view for faqs page
public function index()
{
  $this->template->load('faqs');
}

}


