<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {

    public function up($recipeID = -1)
    {
        $this->template->load('error', array('title' => 'Page Not Done!', "message" => "We need to do this") );
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
