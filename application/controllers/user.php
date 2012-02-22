<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

  public function index($name)
  { 
    $this->template->load('error', array('title' => 'Cookware Not Found!', "message" => "The Cookware with id \"$name\" could not be found!") );
    // print $name;
  }


  public function id($id)
  {
    $this->template->load('error', array('title' => 'Cookware Not Found!', "message" => "The Cookware with id \"$id\" could not be found!") );
    // print $id;
  }
}
