<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commons_model extends CI_Model {

	public function index(){
		$this->load->view('welcome_message');
	}

	public function request_loan($type, $amount, $member){

	}
}
