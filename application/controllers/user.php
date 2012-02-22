<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

  public function index($name)
  {
    print $name;
  }

  public function id($id)
  {
    print $id;
  }
}
