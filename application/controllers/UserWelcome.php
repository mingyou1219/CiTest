<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserWelcome extends CI_Controller {
public function welcome() {
		$this->load->view('welcome_message1');
    }
}