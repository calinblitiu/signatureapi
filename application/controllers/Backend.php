<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
    	$this->load->model('user_model');      
    }

	public function login()
	{
		$email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($email == "" || $password == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

	 	$result = $this->user_model->login($email, $password);
	 	if (count($result) == 0) {
	 		$return_val['code'] = 'error';
        	$return_val['msg'] = 'Invailed User Email or Password.';
        	echo json_encode($return_val);
        	exit();	
	 	}
	 	
	 	$return_val['code'] = 'success';
        $return_val['msg'] = $result[0]; 
	 	echo json_encode($return_val);
	}

	public function signup() {

		$fullname 	= $this->input->post('fullname');
		$email    	= $this->input->post('email');
        $password 	= $this->input->post('password');
		
		if ($fullname == "" || $email == "" || $password == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

        $users = $this->user_model->getUserWhere(array(
        	'login_email' => $email
        ));

        if (count($users) > 0) {
        	$return_val['code'] = 'error';
        	$return_val['msg'] = 'User is already exited! Please try again with another email.';
        	echo json_encode($return_val);
        } else {
        	$user_id = $this->user_model->addUser(array(
        		'full_name'		=> $fullname,
        		'login_email'	=> $email,
        		'password' 		=> password_hash($password, PASSWORD_DEFAULT)
        	));

        	$this->login();
        }	
	}

	public function savethirdpartyconf() {
		$userid = $this->input->post('userId');
		$third_email = $this->input->post('email');
		$third_password = $this->input->post('password');
		if ($userid == "" || $third_email == "" || $third_password == "") {
			$return_val['code'] = 'error';
        	$return_val['msg'] = 'Request Error!';
        	echo json_encode($return_val);
        	exit();
		}

		$users = $this->user_model->getUserWhere(array(
        	'id' => $userid
        ));

        if (count($users) == 0){
        	$return_val['code'] = 'error';
        	$return_val['msg'] = 'User is not exist.';
        	echo json_encode($return_val);
        	exit();
        }

        echo json_encode($users[0]);
	}
}
