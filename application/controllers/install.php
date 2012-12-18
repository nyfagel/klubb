<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	/**
     * This is a demo controller that allows you to add your first user account
     * to the database, please remove this controller afterwards.
     */
    public function index() {
        // load the model
        $this->load->model('user_model');
        
        /* EDIT THESE FIELDS */
        $user = array();
        $user['username'] = 'jan';
        $user['password'] = 'Syster12';
        $user['email'] = 'jan@nyfagel.se';
        
        $id = $this->user_model->create_user($user);
    }
}

?>