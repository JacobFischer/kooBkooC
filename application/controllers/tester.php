<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tester extends CI_Controller {
  public function run()
  {
    $this->load->view('tester/run');
  }
}
  